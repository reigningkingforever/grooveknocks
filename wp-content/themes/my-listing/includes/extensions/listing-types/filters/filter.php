<?php

namespace MyListing\Ext\Listing_Types\Filters;

use \MyListing\Ext\Listing_Types\Designer;

abstract class Filter implements \JsonSerializable {

	protected
		$props = [
			'type'                => 'wp-search',
			'label'               => '',
			'default_label'       => '',
			'placeholder'         => '',
			'options' => [],
		];

	public static $store = null;

	public function __construct( $props = [] ) {
		$this->filter_props();
		$this->set_props( $props );

		if ( ! self::$store ) {
			self::$store = Designer::$store;
		}
	}

	abstract protected function render();

	abstract protected function filter_props();

	final public function print_options() {
		ob_start(); ?>
		<div class="filter-settings-wrapper" v-if="facet.type == '<?php echo esc_attr( $this->props['type'] ) ?>'">
			<?php $this->render() ?>
			<?php $this->options() ?>
		</div>
		<?php return ob_get_clean();
	}

	public function set_props( $props = [] ) {
		foreach ( $props as $name => $value ) {
			if ( isset( $this->props[ $name ] ) ) {
				$this->props[ $name ] = $value;
			}
		}
	}

	public function get_props() {
		return $this->props;
	}

	public function jsonSerialize() {
		return $this->props;
	}

	public function options() {
		$options = array_filter( (array) $this->props['options'], function( $opt ) {
			return is_array( $opt ) && ! empty( $opt['type'] ) && method_exists( $this, sprintf( '%sOption', $opt['type'] ) );
		} ); ?>

		<div class="form-group">
			<?php foreach ( $options as $key => $opt ): $option = sprintf( 'facet.options[%d]', $key ); ?>
				<div v-if="!<?php echo $option ?>.form || <?php echo $option ?>.form === state.search.active_form">
					<?php $this->{$opt['type'].'Option'}($option) ?>
				</div>
			<?php endforeach ?>
		</div>
	<?php }

	protected function getLabelField() { ?>
		<div class="form-group">
			<label>Label</label>
			<input type="text" v-model="facet.label">
		</div>
	<?php }

	protected function getPlaceholderField() { ?>
		<div class="form-group">
			<label>Placeholder</label>
			<input type="text" v-model="facet.placeholder">
		</div>
	<?php }

	protected function getSourceField() {
		$allowed_fields = htmlspecialchars( json_encode( $this->props['allowed_fields'] ), ENT_QUOTES, 'UTF-8' ); ?>
		<div class="form-group">
			<label>Use Field</label>
			<div class="select-wrapper">
				<select v-model="facet.show_field">
					<option v-for="field in fieldsByType(<?php echo $allowed_fields ?>)" :value="field.slug">{{ field.label }}</option>
				</select>
			</div>
		</div>
	<?php }

	protected function textOption( $option ) { ?>
		<div v-if="<?php echo $option ?>.type == 'text'" class="select-option">
			<label>{{ <?php echo $option ?>.label }}</label>
			<input type="text" v-model="<?php echo $option ?>.value">
		</div>
	<?php }

	protected function numberOption( $option ) { ?>
		<div v-if="<?php echo $option ?>.type == 'number'" class="select-option">
			<label>{{ <?php echo $option ?>.label }}</label>
			<input type="number" v-model="<?php echo $option ?>.value" step="any">
		</div>
	<?php }

	protected function checkboxOption( $option ) { ?>
		<div v-if="<?php echo $option ?>.type == 'checkbox'" class="select-option">
			<label>&nbsp;</label>
			<label><input type="checkbox" v-model="<?php echo $option ?>.value"> {{ <?php echo $option ?>.label }}</label>
		</div>
	<?php }

	protected function selectOption( $option ) { ?>
		<div v-if="<?php echo $option ?>.type == 'select'" class="select-option">
			<label>{{ <?php echo $option ?>.label }}</label>
			<div class="select-wrapper">
				<select v-model="<?php echo $option ?>.value">
					<option v-for="(choice_label, choice) in <?php echo $option ?>.choices" :value="choice">{{ choice_label }}</option>
				</select>
			</div>
		</div>
	<?php }

	protected function multiselectOption( $option ) { ?>
		<div v-if="<?php echo $option ?>.type == 'multiselect'" class="select-option">
			<label>{{ <?php echo $option ?>.label }}</label>
			<select v-model="<?php echo $option ?>.value" multiple="multiple">
				<option v-for="(choice_label, choice) in <?php echo $option ?>.choices" :value="choice">{{ choice_label }}</option>
			</select>
		</div>
	<?php }
}
