<template>
    <form-group :id="myId" :label="label" :help="help" :name="name" :pre-label="preLabel" :required="required"
                :value="modelValue" :is-checked-item="isCheckedItem">
        <input class="form-control" :class="{'is-invalid': $page.props.errors[name], 'checked-input': isCheckedItem}" :type="type" v-model="myValue" :id="myId+'Input'"
               :placeholder="placeholder" :aria-placeholder="placeholder" :autofocus="autofocus"
               @input="$emit('update:modelValue', $event.target.value);" :disabled="disabled"
               :required="required" :aria-required="required" :name="name"/>
    </form-group>
</template>

<script>
import FormGroup from "./FormGroup";
import ValueCheck from "./ValueCheck";

export default {
    name: "FormInput",
    components: {ValueCheck, FormGroup},
    props: {
        label: String,
        id: String,
        type: {
            type: String,
            default: 'text',
        },
        required: {
            type: Boolean,
            default: false,
        },
        name: String,
        modelValue: {
            type: null,
        },
        help: String,
        placeholder: String,
        preLabel: String,
        autofocus: Boolean,
        disabled: {
            type: Boolean,
            default: false,
        },
        handleInput: Object,
        isCheckedItem: {
            type: null,
            default: false,
        },
    },
    mounted() {
        if (this.myId == '') this.myId = this._uid;
    },
    data() {
        return {
            errors: this.$page.props.errors,
            error: this.$page.props.errors[this.name] || false,
            myId: this.id || '',
            myValue: this.modelValue,
        }
    },
    watch: {
        modelValue: {
            handler: function (newVal) {
                if (this.required) {
                    this.error = this.$page.props.errors[this.name] = newVal ? '' : 'Dieses Feld darf nicht leer bleiben.';
                    this.$forceUpdate();
                }
            }
        }
    },
}
</script>

<style scoped>
</style>
