<?php
/**
 * Plugin Name: iOS Images Fixer
 * Plugin URI: http://bishoy.me/wp-plugins/ios-images-fixer/
 * Description: This plugin fixes iOS-taken images' orientation upon uploading using ImageMagic Library if available or PHP GD as a fallback. No settings editing required, just activate the plugin and try uploading an image from your idevice! If you like this free plugin, please <a href="http://bishoy.me/donate" target="_blank">consider a donation</a>.
 * Version: 1.0
 * Author: Bishoy A.
 * Author URI: http://bishoy.me
 * License: GPL2
 */

/*  Copyright 2014  Bishoy A.  (email : hi@bishoy.me)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

add_action( 'plugins_loaded', array ( BAImageFixer::get_instance(), 'start' ) );

class BAImageFixer {

	/**
	 * Instance
	 * @var object
	 */
	protected static $instance;

	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @return  object of this class
	 */
	public static function get_instance() {
	
		if ( null === self::$instance ) {
			self::$instance = new self;
		}
		return self::$instance;	
	}

	/**
	 * Start the plugin
	 * @since 1.0
	 */
	public static function start() {
		add_filter( 'wp_handle_upload_prefilter', array( self::get_instance(), 'imf_exif_rotate' ) );
	}

	/**
	 * Rotate images to the correct orientation
	 * @param  array $file $_FILES array
	 * @return array	   $_FILES array in the correct orientation
	 * @since 1.0
	 */
	public static function imf_exif_rotate( $file ){
		$exif = self::imf_exif_orient_correction( $file );
		return $exif;
	}

	/**
	 * Rotate images to the correct orientation
	 * @param  array $file $_FILES array
	 * @return array	   $_FILES array in the correct orientation
	 * @since 1.0
	 */
	public static function imf_exif_orient_correction( $file ) {
		if ( $file['type'] != 'image/jpeg' ) {
			return $file;
		}

		$exif = read_exif_data( $file['tmp_name'] );
		$exif_orient = isset($exif['Orientation'])?$exif['Orientation']:0;
		$rotateImage = 0;

		if ( 6 == $exif_orient ) {
			$rotateImage = 90;
			$imageOrientation = 1;
		} elseif ( 3 == $exif_orient ) {
			$rotateImage = 180;
			$imageOrientation = 1;
		} elseif ( 8 == $exif_orient ) {
			$rotateImage = 270;
			$imageOrientation = 1;
		}

		if ( $rotateImage ) {
			if ( class_exists( 'Imagick' ) ) {
				$imagick = new Imagick();
				$ImagickPixel = new ImagickPixel();
				$imagick->readImage( $file['tmp_name'] );
				$imagick->rotateImage( $ImagickPixel, $rotateImage );
				$imagick->setImageOrientation( $imageOrientation );
				$imagick->writeImage( $file['tmp_name'] );
				$imagick->clear();
				$imagick->destroy();
			} else {
				$rotateImage = -$rotateImage;
				$source = imagecreatefromjpeg( $file['tmp_name'] );
				$rotate = imagerotate( $source, $rotateImage, 0 );
				imagejpeg( $rotate, $file['tmp_name'] );
			}
		}
		return $file;
	}
}