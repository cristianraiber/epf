<?php


class EPFW_Plugin_Utilities {


	/**
	 * Helper function used for formatting asset names
	 *
	 * @param $asset_name
	 *
	 * @return mixed|string
	 */
	function format_asset_name( $asset_name ) {


		$asset_name = str_replace( '/', '', $asset_name );
		$asset_name = str_replace( '_', ' ', $asset_name );
		$asset_name = str_replace( '-', ' ', $asset_name );
		$asset_name = ucwords( $asset_name ); // capitalize

		return $asset_name;
	}
}

$epfw_plugin_utilities = new EPFW_Plugin_Utilities();