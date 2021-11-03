<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Vehicles
 * @subpackage Vehicles/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Vehicles
 * @subpackage Vehicles/admin/partials
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) die;

//Get the active tab from the $_GET param
$tab = isset($_GET['tab']) ? $_GET['tab'] : null;

?>
    <!-- Our admin page content should all be inside .wrap -->
    <div class="wrap">
        <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

        <nav class="nav-tab-wrapper">
            <a href="?page=vehicles" class="nav-tab <?php if( $tab === null ): ?>nav-tab-active<?php endif; ?>">Generar y Exportar</a>
            <a href="?page=vehicles&tab=import" class="nav-tab <?php if( $tab === 'import'): ?>nav-tab-active<?php endif; ?>">Importar Vehiculos</a>
        </nav>

        <div class="tab-content">
            <?php switch($tab) :
                case 'import':
                    ?>
                    <h2><?php echo esc_html__( 'Importar Vehiculos', 'vehicles'); ?></h2>

                    <?php if (isset($_GET['success'])) : ?>
                        <div class="notice notice-success"><p><?php echo esc_html__( 'Importación completada', 'vehicles' ); ?></p></div>
                    <?php elseif(isset($_GET['error'])) : ?>
                        <div class="notice notice-error"><p><?php echo esc_html__( $_GET['error'], 'vehicles' ); ?></p></div>
                    <?php endif; ?>

                    <p><?php echo esc_html__( 'Presione "Importar" para crear vehiculos, en el campo ponga la url del archivo XML', 'vehicles' ); ?></p>

                    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" >
                        <table class="form-table" role="presentation">
                            <input type="hidden" name="action" value="run_import_vehicles">
                            <?php wp_nonce_field( 'run_import_vehicles', 'run_import_vehicles' ); ?>
                            <tr>
                                <th scope="row"><label for="import_url"><?php echo esc_html__( 'Archivo XML', 'vehicles' ); ?></label></th>
                                <td><input required type="text" value="<?php echo get_option('v_import_url'); ?>" name="v_import_url" id="import_url"></td>
                            </tr>
                        </table>
                        <br/>
                        <input type="submit" class="button button-primary" value="<?php echo esc_html__( 'Importar', 'vehicles' ); ?>" />
                    </form>
                    <?php
                    break;
                default:
                    ?>
                    <h2><?php echo esc_html__( 'Generar & Exportar Vehiculos', 'vehicles'); ?></h2>

                    <?php if (isset($_GET['success'])) : ?>
                        <div class="notice notice-success"><p><?php echo esc_html__( 'Exportación completada', 'vehicles' ); ?></p></div>
                    <?php elseif(isset($_GET['error'])) : ?>
                        <div class="notice notice-error"><p><?php echo esc_html__( $_GET['error'], 'vehicles' ); ?></p></div>
                    <?php endif; ?>

                    <p><?php echo esc_html__( 'Presione "Generar & Exportar" para descargar un archivo XML con 400 vehiculos aleatorios', 'vehicles' ); ?></p>

                    <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" >
                        <input type="hidden" name="action" value="run_export_vehicles">
                        <?php wp_nonce_field( 'run_export_vehicles', 'run_export_vehicles' ); ?>
                        <input type="submit" class="button button-primary" value="<?php echo esc_html__( 'Generar & Exportar', 'vehicles' ); ?>" />
                    </form>
                    <?php
                    break;
            endswitch; ?>
        </div>
    </div>

<?php

