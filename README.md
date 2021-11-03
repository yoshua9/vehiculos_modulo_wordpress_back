# vehiculos_modulo_wordpress_back

Realizar un plugin para Wordpress que cumpla los siguientes requisitos:
	CPT llamado vehículos que incluya las siguientes taxonomías, respetando nomenclatura:
	Marca
	Modelo
	Color Exterior
	Además, incluirá las siguientes meta con su correspondiente custom field: 
	Precio Contado
	Precio Financiado
	Potencia

Se permite el uso de ACF, Metabox o cualquier dependencia que considere oportuna.
Añadir una página de configuración dentro del plugin, en el que aparezca un custom field que almacene la URL en la que se encuentra alojado un XML, junto a un botón de importar. 
Al hacer clic en el botón de importar, realizar importación del XML hacia el CPT respetando las nomenclaturas de metas y taxonomías expuestas en los puntos anteriores.
Las taxonomías no podrán repetirse si ya existe alguna con el mismo nombre.
Al final del documento, se adjunta  XML con 3 vehículos. Realizar importación del mismo.
En el mismo plugin, añadir un single template (sin estilos) con las siguientes características:
	Deberá mostrar las 3 taxonomías y las 3 meta del vehículo.
	Deberá de mostrar el descuento en (%) que existe si se financia el vehículo. El descuento debe aparecer formateado sin decimales con redondeo al alza.

Genera un XML con la misma estructura del adjunto, pero que contenga 400 vehículos (datos aleatorios) y optimiza todo lo posible la importación del mismo.
