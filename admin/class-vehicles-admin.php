<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Vehicles
 * @subpackage Vehicles/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the vehicles, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Vehicles
 * @subpackage Vehicles/admin
 * @author     Your Name <email@example.com>
 */
class Vehicles_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vehicles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vehicles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vehicles-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vehicles_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vehicles_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vehicles-admin.js', array( 'jquery' ), $this->version, false );

	}

    // Save custom fields
    public function save_meta_options() {

        if ( ! current_user_can( 'edit_posts' ) ) return;

        global $post;

        update_post_meta($post->ID, "precio_contado", $_POST["precio_contado"]);
        update_post_meta($post->ID, "precio_financiado", $_POST["precio_financiado"]);
        update_post_meta($post->ID, "potencia", $_POST["potencia"]);

    }

    /* Create a meta box for our custom fields */
    public function rerender_meta_options() {

        add_meta_box("vehicle-meta", "Detalles del vehículo", array($this, "display_meta_options"), "vehiculo", "normal", "low");

    }

    // Display meta box and custom fields
    public function display_meta_options() {

        global $post;
        $custom = get_post_custom($post->ID);

        $cash_price = $custom["precio_contado"][0];
        ?>
        <div class="v-field-container">
            <label><?php _e( 'Precio Contado:', $this->plugin_name ); ?></label><input type="number"min="0" name="precio_contado" value="<?php echo $cash_price; ?>" />
        </div>
        <?php

        $financed_price = $custom["precio_financiado"][0];
        ?>
        <div class="v-field-container">
            <label><?php _e( 'Precio Financiado:', $this->plugin_name ); ?></label><input type="number" min="0" name="precio_financiado" value="<?php echo $financed_price; ?>"><br>
        </div>
        <?php

        $power = $custom["potencia"][0];
        ?>
        <div class="v-field-container">
            <label><?php _e( 'Potencia:', $this->plugin_name ); ?></label><input type="number" min="0" name="potencia" value="<?php echo $power; ?>"><br>
        </div>
        <?php
    }


    /**
     * Register the administration menu for this plugin into the WordPress Dashboard menu.
     *
     * @since    1.0.0
     */
    public function add_plugin_admin_menu() {

        /**
         * Add a settings page for this plugin to the Settings menu.
         */
        add_submenu_page( 'tools.php', 'Configuración de Vehículos', 'Vehículos', 'manage_options', $this->plugin_name, array($this, 'display_plugin_setup_page' ) );

    }

    /**
     * Add settings action link to the plugins page.
     *
     * @since    1.0.0
     */
    public function add_action_links( $links ) {

        $settings_link = array( '<a href="' . admin_url( 'tools.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>', );

        return array_merge(  $settings_link, $links );

    }

    /**
     * Render the settings page for this plugin.
     *
     * @since    1.0.0
     */
    public function display_plugin_setup_page() {

        include_once( 'partials/' . $this->plugin_name . '-admin-display.php' );

    }

    /**
     * Validate fields
     * @param  mixed $input as field form settings form
     * @return mixed as validated fields
     */
    public function validate($input) {

        $options = get_option( $this->plugin_name );

        $options['v_import_url'] = ( isset( $input['v_import_url'] ) && ! empty( $input['v_import_url'] ) ) ? 1 : 0;

        return $options;

    }

    public function options_update() {

        register_setting( $this->plugin_name, $this->plugin_name, array(
            'sanitize_callback' => array( $this, 'validate' ),
        ) );

    }

    /**
     *
     */
    public function run_import_vehicles() {
        if ( ! wp_verify_nonce( $_POST['run_import_vehicles'], 'run_import_vehicles' ) ) {
            return;
        }
        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // Update or create option
        update_option('v_import_url', $_POST['v_import_url']);

        $xml = simplexml_load_file( get_option('v_import_url') );

        $error = false;
        if ( $xml ) {
            foreach ($xml->car as $car) {
                if ($car->make && $car->model && $car->color) {
                    $post_id = wp_insert_post(array(
                        'post_type' => 'vehiculo',
                        'post_title' => $car->make . ' ' . $car->model . ' ' . $car->color,
                        'post_content' => '',
                        'post_status' => 'publish',
                    ));


                    if ($car->price) update_post_meta($post_id, "precio_contado", (int) $car->price);
                    if ($car->financial) update_post_meta($post_id, "precio_financiado", (int) $car->financial);
                    if ($car->cv) update_post_meta($post_id, "potencia", (int) $car->cv);


                    wp_set_post_terms($post_id, array($this->find_or_create_term((string)$car->make, 'marca')), 'marca');
                    wp_set_post_terms($post_id, array($this->find_or_create_term((string)$car->model, 'modelo')), 'modelo');
                    wp_set_post_terms($post_id, array($this->find_or_create_term((string)$car->color, 'color_exterior')), 'color_exterior');

                    wp_reset_query();
                }
            }
        } else {
            $error = 'Ha ocurrido un error al leer el archivo XML';
        }

        if ( !$error ) {
            $response = 'success';
        }
        else {
            $response = 'error=' . $error;
        }

        wp_safe_redirect( get_admin_url( null, 'tools.php?page=vehicles&tab=import&' . $response ) );
        exit();
    }


    private function find_or_create_term ($name, $taxonomy) {

        $term = get_term_by('name', $name, $taxonomy);

        if ( $term ) {
            return $term->term_id;
        } else {
            return wp_insert_term($name, $taxonomy)['term_id'];
        }

    }

    public function run_export_vehicles() {

        if (!wp_verify_nonce($_POST['run_export_vehicles'], 'run_export_vehicles')) {
            return;
        }
        if (!current_user_can('manage_options')) {
            return;
        }


        $dom = new DOMDocument('1.0','UTF-8');
        $dom->formatOutput = true;
        $root = $dom->createElement('list');
        for ($i = 0; $i < 4; $i++) {
            $response = file_get_contents('https://random-data-api.com/api/vehicle/random_vehicle?size=100');
            $response = json_decode($response);

            foreach ($response as $car) {
                $make_and_model = explode(' ', $car->make_and_model);

                $dom->appendChild($root);

                $xml_car = $dom->createElement('car');
                $root->appendChild($xml_car);

                $xml_car->appendChild( $dom->createElement('make', $make_and_model[0]) );
                $xml_car->appendChild( $dom->createElement('model', $make_and_model[1]) );
                $xml_car->appendChild( $dom->createElement('color', $car->color) );

                $xml_car->appendChild( $dom->createElement('cv', rand(10, 100)) );

                $price = rand(10000, 100000);
                $xml_car->appendChild( $dom->createElement('price', $price) );
                $xml_car->appendChild( $dom->createElement('financial', rand(10000, $price)) );
            }
        }


        header("refresh: 2; url=" . get_admin_url( null, 'tools.php?page=vehicles'));


        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="vehiculos.xml"');
        echo $dom->saveXML();

        exit();
    }
}
