<?php

 // Die if file is called directly
 if ( ! defined( 'WPINC' ) ) {
	die;
}

class Cubilis_Fastbooker_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Cubilis_Fastbooker_Widget', // Base ID
			__('Cubilis Fastbooker Widget', 'cubilis-fastbooker'), // Name
			array( 'description' => __( 'Cubilis Fastbooker Integration', 'cubilis-fastbooker' ), ) // Args
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) 
	{
		 // Check if deactivated
		 if (!get_option('cubilis_fastbooker_active')) {
			return;
		 }

		// Set all user chosen colors
		$cubilisFontColor = isset($instance['font-color']) ? $instance['font-color'] : '#212121';
		$cubilisButtonFontColor = isset($instance['button-font-color']) ? $instance['button-font-color'] : '#ffffff';
		$cubilisButtonFontColorHover = isset($instance['button-hover-font-color']) ? $instance['button-hover-font-color'] : '#ffffff';
		$cubilisButtonColor = isset($instance['button-back-color']) ? $instance['button-back-color'] : '#212121';
		$cubilisButtonColorHover = isset($instance['button-hover-color']) ? $instance['button-hover-color'] : '#545454';
		$cubilisCalenderColor = isset($instance['calender-color']) ? $instance['calender-color'] : '#212121';
		$cubilisIconColor = isset($instance['icon-color']) ? $instance['icon-color'] : '#212121';
		$cubilisBorderColor = isset($instance['border-color']) ? $instance['border-color'] : '#dddddd';

		// Get language
		$wordpressLang =  strtolower(substr(get_locale(), 0, 2));
		$supportedLang = array('nl', 'en', 'fr', 'de', 'es', 'it', 'ru', 'zh');

		$cubilisLang = get_option('cubilis_fastbooker_lang');
		if (in_array($wordpressLang, $supportedLang)) {
			$cubilisLang = $wordpressLang;
		}

		// Get booking urls
		$bookUrl = "https://reservations.cubilis.eu/" . get_option('cubilis_fastbooker_identifier') . "/Rooms/Select?Language=" . $cubilisLang;
		$generalUrl = "https://reservations.cubilis.eu/" . get_option('cubilis_fastbooker_identifier') . "/Rooms/GeneralAvailability?Language=" . $cubilisLang;

		// Get identifier
		$cubilisIdentifier = get_option('cubilis_fastbooker_identifier');

		// Get preferences
		$hasCubilisDiscount = get_option('cubilis_fastbooker_discount');
		$hasCubilisGeneralUrl = get_option('cubilis_fastbooker_general_overview');
		$hasCubilisIcons = get_option('cubilis_fastbooker_icons');

		// Get a GUID
		$guid = sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	
		?>

		<style>
			<?php echo ".cubilis-fastbooker-" . $guid ?> .cubilis-fastbooker__label {
				color: <?php echo $cubilisFontColor ?> !important;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .cubilis-fastbooker__input-container {
				border-color: <?php echo $cubilisBorderColor ?> !important;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .cubilis-fastbooker__submit {
				color: <?php echo $cubilisButtonFontColor ?> !important;
				background-color: <?php echo $cubilisButtonColor ?> !important;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .cubilis-fastbooker__submit:hover {
				color: <?php echo $cubilisButtonFontColorHover ?> !important;
				background-color: <?php echo $cubilisButtonColorHover ?> !important;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .cubilis-fastbooker__link {
				color: <?php echo $cubilisFontColor ?> !important;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .cubilis-fastbooker__icon {
				color: <?php echo $cubilisIconColor ?> !important;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .cubilis-fastbooker__footer p {
				color: <?php echo $cubilisFontColor ?> !important;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .calendar__day.isPicked, 
			<?php echo ".cubilis-fastbooker-" . $guid ?> .calendar__day.isToday:focus, 
			<?php echo ".cubilis-fastbooker-" . $guid ?> .calendar__day.isToday:hover {
        background-color: <?php echo $cubilisCalenderColor ?> !important;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .calendar__day.isInbetween{
				background-color: <?php echo $cubilisCalenderColor ?> !important;
				opacity: .6;
			}

			<?php echo ".cubilis-fastbooker-" . $guid ?> .calendar__day:focus, .calendar__day:hover{
				background-color: <?php echo $cubilisCalenderColor ?> !important;
				opacity: .6;
			}

		</style>

		<?php echo $args['before_widget']; ?>
		<div class="cubilis-fastbooker cubilis-fastbooker-<?php echo $guid ?>">
			<div class="cubilis-fastbooker__header">
				<?php echo $args['before_title']; ?>
					<?php echo apply_filters( 'widget_title', empty($instance['title']) ? '' : $instance['title'], $instance ); ?>
				<?php echo $args['after_title']; ?>
			</div>
			<div class="cubilis-fastbooker__body">
		 		<form class="cubilis-fastbooker__form" data-locale="<?php echo $cubilisLang ?>" data-general-url="<?php echo $generalUrl ?>" data-book-url="<?php echo $bookUrl ?>">
					<div class="cubilis-fastbooker__calender">	
						<label class="cubilis-fastbooker__group">
							<p class="cubilis-fastbooker__label cubilis-fastbooker__date"><?php _e('Arrival', 'cubilis-fastbooker') ?></p>
							<div class="cubilis-fastbooker__input-container cubilis-fastbooker--pointer">
								<span class="cubilis-fastbooker__input cubilis-fastbooker__startDateLabel"><?php _e('Arrival', 'cubilis-fastbooker') ?></span>
								<input hidden type="text" readonly class="cubilis-fastbooker__input cubilis-fastbooker__startDate" id="cubilis-fastbooker__startDate" name="cubilis-fastbooker__startDate">
								<?php if ($hasCubilisIcons) : ?>
									<svg style="height:1.2em;" class="cubilis-fastbooker__icon" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="calendar-alt" class="svg-inline--fa fa-calendar-alt fa-w-14" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm320-196c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zM192 268c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zM64 268c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12v-40zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"/></svg>
								<?php endif; ?>
							</div>
						</label>
						<label class="cubilis-fastbooker__group">
							<p class="cubilis-fastbooker__label cubilis-fastbooker__date"><?php _e('Departure', 'cubilis-fastbooker') ?></p>
							<div class="cubilis-fastbooker__input-container cubilis-fastbooker--pointer">
								<span class="cubilis-fastbooker__input cubilis-fastbooker__endDateLabel"><?php _e('Departure', 'cubilis-fastbooker') ?></span>
								<input hidden type="text" readonly class="cubilis-fastbooker__input cubilis-fastbooker__endDate" id="cubilis-fastbooker__endDate" name="cubilis-fastbooker__endDate">
								<?php if ($hasCubilisIcons) : ?>
									<svg style="height:1.2em;" class="cubilis-fastbooker__icon" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="calendar-alt" class="svg-inline--fa fa-calendar-alt fa-w-14" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M0 464c0 26.5 21.5 48 48 48h352c26.5 0 48-21.5 48-48V192H0v272zm320-196c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zM192 268c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12h-40c-6.6 0-12-5.4-12-12v-40zM64 268c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12v-40zm0 128c0-6.6 5.4-12 12-12h40c6.6 0 12 5.4 12 12v40c0 6.6-5.4 12-12 12H76c-6.6 0-12-5.4-12-12v-40zM400 64h-48V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H160V16c0-8.8-7.2-16-16-16h-32c-8.8 0-16 7.2-16 16v48H48C21.5 64 0 85.5 0 112v48h448v-48c0-26.5-21.5-48-48-48z"/></svg>
								<?php endif; ?>
							</div>
						</label>
					</div>
					<?php if ($hasCubilisDiscount) : ?>
						<label class="cubilis-fastbooker__group cubilis-fastbooker__discountLabel">
							<p class="cubilis-fastbooker__label"><?php _e('Discount code', 'cubilis-fastbooker') ?></p>
							<div class="cubilis-fastbooker__input-container">
								<input placeholder="<?php _e('Discount code', 'cubilis-fastbooker') ?>" type="text" class="cubilis-fastbooker__input cubilis-fastbooker__discount" id="cubilis-fastbooker__discount" name="cubilis-fastbooker__discount">
								<?php if ($hasCubilisIcons) : ?>
									<svg style="height:1.2em;" class="cubilis-fastbooker__icon" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="tags" class="svg-inline--fa fa-tags fa-w-20" role="img" viewBox="0 0 640 512"><path fill="currentColor" d="M497.941 225.941L286.059 14.059A48 48 0 0 0 252.118 0H48C21.49 0 0 21.49 0 48v204.118a48 48 0 0 0 14.059 33.941l211.882 211.882c18.744 18.745 49.136 18.746 67.882 0l204.118-204.118c18.745-18.745 18.745-49.137 0-67.882zM112 160c-26.51 0-48-21.49-48-48s21.49-48 48-48 48 21.49 48 48-21.49 48-48 48zm513.941 133.823L421.823 497.941c-18.745 18.745-49.137 18.745-67.882 0l-.36-.36L527.64 323.522c16.999-16.999 26.36-39.6 26.36-63.64s-9.362-46.641-26.36-63.64L331.397 0h48.721a48 48 0 0 1 33.941 14.059l211.882 211.882c18.745 18.745 18.745 49.137 0 67.882z"/></svg>
								<?php endif; ?>
							</div>
						</label>
					<?php endif; ?>
		 			<input type="submit" class="cubilis-fastbooker__submit" name="cubilis-fastbooker__submit" value="<?php _e('Check availability', 'cubilis-fastbooker') ?>"/>
					<?php if ($hasCubilisGeneralUrl) : ?>
						<a class="cubilis-fastbooker__link" href="<?php echo $generalUrl ?>"><?php _e('General availability', 'cubilis-fastbooker') ?></a>
					<?php endif; ?>
				</form>
			</div>
			<div class="cubilis-fastbooker__footer">
				<p>Powered by</p>
				<a href="https://www.cubilis.com/nl/" target="_blank">
					<svg style="height:1.2em;" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Laag_1" x="0px" y="0px" viewBox="0 0 1129.247 277.987" style="enable-background:new 0 0 1129.247 277.987;" xml:space="preserve"><path style="fill:#C8C7C7;" d="M349.187,249.958v-6.425c-5.996,7.587-12.296,13.947-18.903,19.086s-13.827,8.964-21.655,11.469   c-7.831,2.509-16.763,3.765-26.794,3.765c-12.112,0-22.972-2.513-32.574-7.526c-9.608-5.013-17.039-11.931-22.299-20.74   c-6.24-10.64-9.359-25.935-9.359-45.876v-99.286c0-10.031,2.263-17.527,6.79-22.48c4.525-4.957,10.521-7.431,17.985-7.431   c7.585,0,13.701,2.509,18.352,7.522c4.648,5.018,6.974,12.479,6.974,22.389v80.2c0,11.624,0.978,21.379,2.936,29.268   c1.956,7.894,5.473,14.073,10.553,18.538c5.074,4.465,11.957,6.697,20.645,6.697c8.442,0,16.394-2.505,23.858-7.522   c7.462-5.018,12.907-11.564,16.333-19.639c2.813-7.095,4.221-22.631,4.221-46.614v-60.929c0-9.91,2.323-17.372,6.974-22.389   c4.648-5.013,10.705-7.522,18.168-7.522c7.462,0,13.457,2.474,17.985,7.431c4.525,4.953,6.79,12.449,6.79,22.48v145.162   c0,9.543-2.174,16.702-6.516,21.474c-4.344,4.772-9.94,7.155-16.791,7.155c-6.853,0-12.512-2.474-16.977-7.431   C351.417,265.832,349.187,258.888,349.187,249.958z"/><path style="fill:#C8C7C7;" d="M483.488,28.629v76.53c9.42-9.785,19.023-17.281,28.813-22.48   c9.787-5.199,21.899-7.803,36.337-7.803c16.638,0,31.226,3.947,43.768,11.84c12.54,7.889,22.266,19.332,29.182,34.316   c6.909,14.988,10.368,32.761,10.368,53.316c0,15.17-1.926,29.087-5.782,41.747c-3.852,12.665-9.45,23.646-16.791,32.943   c-7.341,9.301-16.243,16.487-26.701,21.565c-10.463,5.074-21.994,7.613-34.594,7.613c-7.708,0-14.956-0.915-21.748-2.751   c-6.788-1.835-12.57-4.249-17.342-7.25c-4.772-2.997-8.841-6.084-12.203-9.267c-3.368-3.178-7.801-7.95-13.306-14.315v4.953   c0,9.426-2.265,16.551-6.79,21.383c-4.528,4.832-10.277,7.246-17.251,7.246c-7.097,0-12.756-2.414-16.974-7.246   c-4.223-4.832-6.333-11.957-6.333-21.383V30.831c0-10.152,2.047-17.829,6.147-23.028C446.385,2.604,452.106,0,459.447,0   c7.708,0,13.641,2.479,17.801,7.436C481.407,12.389,483.488,19.457,483.488,28.629z M485.874,177.466   c0,19.945,4.556,35.266,13.671,45.971c9.113,10.709,21.075,16.059,35.879,16.059c12.6,0,23.458-5.475,32.576-16.426   c9.111-10.946,13.671-26.638,13.671-47.072c0-13.213-1.898-24.592-5.689-34.135c-3.793-9.543-9.176-16.914-16.15-22.113   s-15.111-7.799-24.408-7.799c-9.543,0-18.048,2.6-25.509,7.799c-7.464,5.199-13.336,12.725-17.618,22.571   C488.013,152.17,485.874,163.885,485.874,177.466z"/><path style="fill:#C8C7C7;" d="M697.472,51.204c-6.974,0-12.939-2.137-17.892-6.425c-4.957-4.279-7.434-10.333-7.434-18.166   c0-7.095,2.537-12.937,7.615-17.527c5.076-4.586,10.981-6.883,17.711-6.883c6.484,0,12.233,2.086,17.251,6.244   c5.016,4.158,7.524,10.217,7.524,18.166c0,7.708-2.448,13.736-7.341,18.076C710.012,49.032,704.2,51.204,697.472,51.204z    M722.247,102.957v144.799c0,10.031-2.386,17.618-7.157,22.756s-10.828,7.703-18.168,7.703c-7.341,0-13.304-2.63-17.894-7.889   c-4.586-5.259-6.881-12.782-6.881-22.571V104.425c0-9.91,2.295-17.372,6.881-22.389c4.59-5.013,10.553-7.522,17.894-7.522   c7.341,0,13.397,2.509,18.168,7.522C719.861,87.053,722.247,94.027,722.247,102.957z"/><path style="fill:#C8C7C7;" d="M769.578,247.756V30.469c0-10.031,2.23-17.618,6.7-22.756C780.74,2.574,786.766,0,794.353,0   c7.585,0,13.701,2.543,18.352,7.617c4.648,5.078,6.974,12.695,6.974,22.851v217.287c0,10.156-2.358,17.769-7.064,22.847   c-4.713,5.074-10.8,7.613-18.261,7.613c-7.341,0-13.304-2.63-17.894-7.889C771.873,265.067,769.578,257.545,769.578,247.756z"/><path style="fill:#C8C7C7;" d="M892.335,51.204c-6.974,0-12.939-2.137-17.892-6.425c-4.957-4.279-7.434-10.333-7.434-18.166   c0-7.095,2.537-12.937,7.615-17.527c5.076-4.586,10.981-6.883,17.711-6.883c6.484,0,12.233,2.086,17.251,6.244   c5.016,4.158,7.524,10.217,7.524,18.166c0,7.708-2.448,13.736-7.341,18.076C904.874,49.032,899.062,51.204,892.335,51.204z    M917.11,102.957v144.799c0,10.031-2.386,17.618-7.157,22.756c-4.772,5.139-10.828,7.703-18.168,7.703   c-7.341,0-13.304-2.63-17.894-7.889c-4.586-5.259-6.881-12.782-6.881-22.571V104.425c0-9.91,2.295-17.372,6.881-22.389   c4.59-5.013,10.553-7.522,17.894-7.522c7.341,0,13.397,2.509,18.168,7.522C914.724,87.053,917.11,94.027,917.11,102.957z"/><path style="fill:#C8C7C7;" d="M1130.176,212.702c0,13.827-3.366,25.663-10.094,35.512c-6.73,9.85-16.672,17.311-29.823,22.389   c-13.153,5.074-29.149,7.613-47.989,7.613c-17.985,0-33.401-2.751-46.247-8.256c-12.846-5.506-22.329-12.389-28.446-20.645   c-6.119-8.261-9.176-16.547-9.176-24.868c0-5.506,1.956-10.212,5.873-14.129c3.914-3.917,8.869-5.873,14.865-5.873   c5.259,0,9.297,1.282,12.112,3.852c2.813,2.569,5.506,6.179,8.075,10.83c5.139,8.93,11.285,15.597,18.445,20.001   c7.155,4.404,16.912,6.607,29.27,6.607c10.031,0,18.259-2.232,24.684-6.697c6.421-4.465,9.634-9.573,9.634-15.325   c0-8.809-3.336-15.234-10.001-19.267c-6.672-4.042-17.65-7.893-32.943-11.564c-17.251-4.279-31.289-8.779-42.119-13.49   c-10.826-4.707-19.483-10.916-25.967-18.628c-6.486-7.704-9.727-17.186-9.727-28.443c0-10.031,2.997-19.514,8.992-28.443   c5.994-8.93,14.833-16.059,26.52-21.383c11.68-5.32,25.783-7.98,42.3-7.98c12.967,0,24.62,1.347,34.959,4.033   c10.338,2.695,18.963,6.304,25.878,10.83c6.909,4.53,12.171,9.543,15.783,15.049c3.606,5.506,5.413,10.89,5.413,16.15   c0,5.752-1.928,10.463-5.78,14.133c-3.856,3.67-9.331,5.501-16.426,5.501c-5.139,0-9.515-1.468-13.123-4.404   c-3.61-2.936-7.738-7.341-12.386-13.213c-3.793-4.888-8.258-8.809-13.397-11.745c-5.139-2.936-12.112-4.404-20.921-4.404   c-9.055,0-16.579,1.93-22.573,5.782c-5.996,3.856-8.992,8.658-8.992,14.41c0,5.259,2.202,9.573,6.607,12.937   s10.338,6.149,17.801,8.351c7.462,2.202,17.739,4.892,30.831,8.075c15.537,3.791,28.23,8.321,38.079,13.576   c9.847,5.264,17.311,11.473,22.389,18.628C1127.635,195.36,1130.176,203.526,1130.176,212.702z"/><path style="fill:#2F2778;" d="M177.157,214.83c-8.965-8.181-22.859-7.552-31.04,1.413c-4.768,5.215-10.796,9.427-17.922,12.495  c-7.317,3.157-15.132,4.753-23.247,4.753c-17.087,0-30.725-5.683-42.912-17.886c8.452,8.613,8.379,22.442-0.191,30.966  c-4.292,4.263-9.895,6.387-15.497,6.387c-5.64,0-11.287-2.162-15.579-6.475c20.427,20.536,45.387,30.952,74.179,30.952  c14.136,0,27.818-2.805,40.649-8.35c12.883-5.552,23.972-13.367,32.966-23.217C186.751,236.913,186.115,223.011,177.157,214.83z"/><path style="fill:#A9DAE5;" d="M178.768,99.306c-2.044-1.97-4.131-3.867-6.218-5.632c-19.659-16.648-42.4-25.093-67.603-25.093  c-28.682,0-53.561,10.122-73.945,30.081c8.665-8.335,22.449-8.159,30.901,0.44c8.503,8.649,8.386,22.565-0.271,31.069  c12.246-12.034,26.009-17.645,43.316-17.645c14.92,0,27.378,4.665,39.199,14.686c1.362,1.149,2.739,2.395,4.094,3.706  c4.263,4.116,9.763,6.167,15.256,6.167c5.758,0,11.5-2.249,15.814-6.709C187.74,121.645,187.492,107.736,178.768,99.306z"/><path style="fill:#48BBDD;" d="M30.564,129.907c-8.51-8.649-8.393-22.566,0.264-31.069c0.058-0.059,0.117-0.117,0.176-0.176  c-0.058,0.059-0.117,0.11-0.176,0.169C10.371,118.943,0,143.64,0,172.24c0,28.733,10.357,53.716,30.769,74.246  c-8.555-8.606-8.518-22.515,0.088-31.076c8.606-8.556,22.515-8.519,31.069,0.087h0.007c-12.268-12.334-17.988-26.081-17.988-43.257  c0-16.838,5.625-30.205,17.687-42.069C52.983,138.68,39.074,138.564,30.564,129.907z"/><path style="fill:#A9DAE5;" d="M61.904,99.102c-8.452-8.599-22.236-8.775-30.901-0.44c-0.058,0.059-0.117,0.117-0.176,0.176  c-8.657,8.504-8.774,22.42-0.264,31.069c8.511,8.657,22.42,8.774,31.069,0.264C70.29,121.667,70.407,107.751,61.904,99.102z"/><path style="fill:#00A8D6;" d="M61.904,99.102c-8.452-8.599-22.236-8.775-30.901-0.44c-0.058,0.059-0.117,0.117-0.176,0.176  c-8.657,8.504-8.774,22.42-0.264,31.069c8.511,8.657,22.42,8.774,31.069,0.264C70.29,121.667,70.407,107.751,61.904,99.102z"/><path style="fill:#2F2778;" d="M61.845,246.573c8.57-8.525,8.643-22.353,0.191-30.966c-0.037-0.037-0.066-0.066-0.102-0.11h-0.007  c-8.555-8.606-22.463-8.643-31.069-0.087c-8.606,8.562-8.642,22.47-0.088,31.076c4.292,4.313,9.939,6.475,15.579,6.475  C51.95,252.96,57.553,250.836,61.845,246.573z"/><path style="fill:#265696;" d="M61.845,246.573c8.57-8.525,8.643-22.353,0.191-30.966c-0.037-0.037-0.066-0.066-0.102-0.11h-0.007  c-8.555-8.606-22.463-8.643-31.069-0.087c-8.606,8.562-8.642,22.47-0.088,31.076c4.292,4.313,9.939,6.475,15.579,6.475  C51.95,252.96,57.553,250.836,61.845,246.573z"/></svg>
				</a>
			</div>
		</div>
		<?php echo $args['after_widget']; ?>

		<?php
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) 
	{
		// Load jQuery
		wp_enqueue_script('jquery');
	
		// Load Spectrum
		wp_register_script('cubilis-fastbooker-spectrum-js', plugins_url( plugin_basename( dirname( __FILE__ ) ) . '/../js/spectrum.js'), array('jquery'), '1.0', true);
		wp_enqueue_script('cubilis-fastbooker-spectrum-js');
	
		wp_register_style('cubilis-fastbooker-spectrum-css', plugins_url( plugin_basename( dirname( __FILE__ ) ) . '/../css/spectrum.css'), null, '1.0', 'all');
		wp_enqueue_style('cubilis-fastbooker-spectrum-css');
	
		// Load custom js and css
		wp_register_script('cubilis-fastbooker-admin-js', plugins_url( plugin_basename( dirname( __FILE__ ) ) . '/../js/admin.js'), array('jquery', 'cubilis-fastbooker-spectrum-js'), '1.0', true);
		wp_enqueue_script('cubilis-fastbooker-admin-js');
	
		wp_register_style('cubilis-fastbooker-admin-css', plugins_url( plugin_basename( dirname( __FILE__ ) ) . '/../css/admin.css'), null, '1.0', 'all');
		wp_enqueue_style('cubilis-fastbooker-admin-css');
		
		// Set default colors
		$cubilisFastbooker_fontColor = '#212121';
		$cubilisFastbooker_buttonFontColor = '#ffffff';
		$cubilisFastbooker_buttonFontColorHover = '#ffffff';
		$cubilisFastbooker_buttonBackColor = '#545454';
		$cubilisFastbooker_buttonBackColorHover = '#212121';
		$cubilisFastbooker_calenderColor = '#212121';
		$cubilisFastbooker_iconColor = '#212121';
		$cubilisFastbooker_borderColor = '#dddddd';

		// Get saved options
		if (isset($instance['title'])) {
			$cubilisFastbooker_title = $instance['title'];
		}

		if (isset($instance['font-color'])) {
			$cubilisFastbooker_fontColor = $instance['font-color'];
		}

		if (isset($instance['button-font-color'])) {
			$cubilisFastbooker_buttonFontColor = $instance['button-font-color'];
		}

		if (isset($instance['button-back-color'])) {
			$cubilisFastbooker_buttonBackColor = $instance['button-back-color'];
		}

		if (isset($instance['button-hover-color'])) {
			$cubilisFastbooker_buttonBackColorHover = $instance['button-hover-color'];
		}

		if (isset($instance['button-hover-font-color'])) {
			$cubilisFastbooker_buttonFontColorHover = $instance['button-hover-font-color'];
		}

		if (isset($instance['calender-color'])) {
			$cubilisFastbooker_calenderColor = $instance['calender-color'];
		}

		if (isset($instance['icon-color'])) {
			$cubilisFastbooker_iconColor = $instance['icon-color'];
		}

		if (isset($instance['border-color'])) {
			$cubilisFastbooker_borderColor = $instance['border-color'];
		}
		 
		?>
		
		<section class="cubilis-fastbooker" data-new-render="true">
			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'cubilis-fastbooker' ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_title ); ?>">
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'font-color' ); ?>"><?php _e( 'Font color:', 'cubilis-fastbooker' ); ?></label>
				<div class="cubilis-fastbooker-container">
					<input type="text" class="cubilis-fastbooker-color" id="<?php echo $this->get_field_id( 'font-color' ); ?>" name="<?php echo $this->get_field_name( 'font-color' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_fontColor ); ?>">
				</div>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'button-font-color' ); ?>"><?php _e( 'Button text color:', 'cubilis-fastbooker' ); ?></label>
				<div class="cubilis-fastbooker-container">
					<input type="text" class="cubilis-fastbooker-color" id="<?php echo $this->get_field_id( 'button-font-color' ); ?>" name="<?php echo $this->get_field_name( 'button-font-color' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_buttonFontColor ); ?>">
				</div>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'button-hover-font-color' ); ?>"><?php _e( 'Button text color (hover):', 'cubilis-fastbooker' ); ?></label>
				<div class="cubilis-fastbooker-container">
					<input type="text" class="cubilis-fastbooker-color" id="<?php echo $this->get_field_id( 'button-hover-font-color' ); ?>" name="<?php echo $this->get_field_name( 'button-hover-font-color' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_buttonFontColorHover ); ?>">
				</div>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'button-back-color' ); ?>"><?php _e( 'Button color:', 'cubilis-fastbooker' ); ?></label>
				<div class="cubilis-fastbooker-container">
					<input type="text" class="cubilis-fastbooker-color" id="<?php echo $this->get_field_id( 'button-back-color' ); ?>" name="<?php echo $this->get_field_name( 'button-back-color' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_buttonBackColor ); ?>">
				</div>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'button-hover-color' ); ?>"><?php _e( 'Button color (hover):', 'cubilis-fastbooker' ); ?></label>
				<div class="cubilis-fastbooker-container">
					<input type="text" class="cubilis-fastbooker-color" id="<?php echo $this->get_field_id( 'button-hover-color' ); ?>" name="<?php echo $this->get_field_name( 'button-hover-color' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_buttonBackColorHover ); ?>">
				</div>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'calender-color' ); ?>"><?php _e( 'Calender color (hover):', 'cubilis-fastbooker' ); ?></label>
				<div class="cubilis-fastbooker-container">
					<input type="text" class="cubilis-fastbooker-color" id="<?php echo $this->get_field_id( 'calender-color' ); ?>" name="<?php echo $this->get_field_name( 'calender-color' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_calenderColor ); ?>">
				</div>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'border-color' ); ?>"><?php _e( 'Input border color:', 'cubilis-fastbooker' ); ?></label>
				<div class="cubilis-fastbooker-container">
					<input type="text" class="cubilis-fastbooker-color" id="<?php echo $this->get_field_id( 'border-color' ); ?>" name="<?php echo $this->get_field_name( 'border-color' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_borderColor ); ?>">
				</div>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id( 'icon-color' ); ?>"><?php _e( 'Icon color:', 'cubilis-fastbooker' ); ?></label>
				<div class="cubilis-fastbooker-container">
					<input type="text" class="cubilis-fastbooker-color" id="<?php echo $this->get_field_id( 'icon-color' ); ?>" name="<?php echo $this->get_field_name( 'icon-color' ); ?>" value="<?php echo esc_attr( $cubilisFastbooker_iconColor ); ?>">
				</div>
			</p>
		</section>
		<?php
	}
	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) 
	{
		// validate new instance colors
		$pattern = '/#[a-zA-Z0-9]{6}|rgb\((?:\s*\d+\s*,){2}\s*[\d]+\)|rgba\((\s*\d+\s*,){3}[\d\.]+\)|hsl\(\s*\d+\s*(\s*\,\s*\d+\%){2}\)|hsla\(\s*\d+(\s*,\s*\d+\s*\%){2}\s*\,\s*[\d\.]+\)/';
		$new_instance['font-color'] = preg_match($pattern, $new_instance['font-color']) ? $new_instance['font-color'] : null;
		$new_instance['button-font-color'] = preg_match($pattern, $new_instance['button-font-color']) ? $new_instance['button-font-color'] : null;
		$new_instance['button-hover-font-color'] = preg_match($pattern, $new_instance['button-hover-font-color']) ? $new_instance['button-hover-font-color'] : null;
		$new_instance['button-back-color'] = preg_match($pattern, $new_instance['button-back-color']) ? $new_instance['button-back-color'] : null;
		$new_instance['button-hover-color'] = preg_match($pattern, $new_instance['button-hover-color']) ? $new_instance['button-hover-color'] : null;
		$new_instance['calender-color'] = preg_match($pattern, $new_instance['calender-color']) ? $new_instance['calender-color'] : null;
		$new_instance['icon-color'] = preg_match($pattern, $new_instance['icon-color']) ? $new_instance['icon-color'] : null;
		$new_instance['border-color'] = preg_match($pattern, $new_instance['border-color']) ? $new_instance['border-color'] : null;

		// Set new values
		$instance = array();

		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? sanitize_text_field( $new_instance['title'] ) : '';
		$instance['font-color'] = ( ! empty( $new_instance['font-color'] ) ) ? sanitize_text_field( $new_instance['font-color'] ) : '';
		$instance['button-font-color'] = ( ! empty( $new_instance['button-font-color'] ) ) ? sanitize_text_field( $new_instance['button-font-color'] ) : '';
		$instance['button-hover-font-color'] = ( ! empty( $new_instance['button-hover-font-color'] ) ) ? sanitize_text_field( $new_instance['button-hover-font-color'] ) : '';
		$instance['button-back-color'] = ( ! empty( $new_instance['button-back-color'] ) ) ? sanitize_text_field( $new_instance['button-back-color'] ) : '';
		$instance['button-hover-color'] = ( ! empty( $new_instance['button-hover-color'] ) ) ? sanitize_text_field( $new_instance['button-hover-color'] ) : '';
		$instance['calender-color'] = ( ! empty( $new_instance['calender-color'] ) ) ? sanitize_text_field( $new_instance['calender-color'] ) : '';
		$instance['icon-color'] = ( ! empty( $new_instance['icon-color'] ) ) ? sanitize_text_field( $new_instance['icon-color'] ) : '';
		$instance['border-color'] = ( ! empty( $new_instance['border-color'] ) ) ? sanitize_text_field( $new_instance['border-color'] ) : '';

		return $instance;
	}
	
} // class Cubilis_Fastbooker_Widget