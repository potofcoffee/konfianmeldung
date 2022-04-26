<template>
    <span :class="(value ? 'mdi mdi-check-circle' : 'mdi mdi-close-circle')"></span>
</template>

<script>
export default {
    name: "ValueCheck",
    props: ['value']
}
</script>

<style scoped>
.mdi.mdi-check-circle {
    color: green;
}
.mdi.mdi-close-circle {
    color: red;
}
</style>
