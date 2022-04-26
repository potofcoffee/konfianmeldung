<template>
    <div class="form-group mb-3" :class="{'form-group-required' : required}" :title="required ? 'Dieses Feld muss ausgefüllt werden.' : ''">
        <value-check v-if="isCheckedItem" :value="value" />
        <label v-if="label" :for="id+'Input'" class="control-label"><span v-if="preLabel" :class="preLabel"></span> {{ label }}</label>
        <slot />
        <small v-if="error" :key="error" class="invalid-feedback">{{ error || false }}</small>
        <div v-else><small v-if="help" class="form-text text-muted">{{ help }}</small></div>
    </div>
</template>

<script>
import ValueCheck from "./ValueCheck";
export default {
    name: "FormGroup",
    components: {ValueCheck},
    props: ['id', 'name', 'label', 'help', 'preLabel', 'required', 'value', 'isCheckedItem'],
    updated() {
        this.errors = this.$page.props.errors;
        this.error = this.errors[this.name] || false;
    },
    data() {
        const errors = this.$page.props.errors;
        return {
            errors: errors,
            error: errors[this.name] || false,
        }
    },
    watch: {
        value: {
            handler: function(newVal) {
                if (this.required) {
                    this.error = this.$page.props.errors[this.name] = newVal ? '' : 'Dieses Feld darf nicht leer bleiben.';
                    this.$forceUpdate();
                }
            }
        },
        '$page.props.errors': function(newVal) {
            this.errors = this.$page.props.errors;
            this.error = this.errors[this.name] || false;
            this.$forceUpdate();
        }
    }
}
</script>

<style scoped>
.form-group.form-group-required .control-label:after {
    color: #d00;
    content: "*";
    position: absolute;
    margin-left: 3px;
}

</style>
