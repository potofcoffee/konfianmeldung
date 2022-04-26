<template>
    <form-group :id="myId" :label="label" :help="help" :name="name" :pre-label="preLabel" :required="required">
        <textarea class="form-control" :class="{'is-invalid': $page.props.errors[name]}" :rows="rows" v-model="myValue" :id="myId+'Input'"
                  :placeholder="placeholder" :aria-placeholder="placeholder" :disabled="disabled" :name="name" :aria-required="required"
                  @input="$emit('update:modelValue', $event.target.value)" />
    </form-group>
</template>

<script>
import FormGroup from "./FormGroup";
export default {
    name: "FormTextarea",
    components: {FormGroup},
    props: {
        label: String,
        id: String,
        rows: {
            type: Number,
            default: 5,
        },
        name: String,
        value: String,
        help: String,
        placeholder: String,
        error: String,
        preLabel: String,
        required: Boolean,
        disabled: {
            type: Boolean,
            default: false,
        },
    },
    mounted() {
        if (this.myId == '') this.myId = this._uid;
    },
    data() {
        return {
            myId: this.id || '',
            myValue: this.value,
        }
    }
}
</script>

<style scoped>

</style>
