<template>
    <div class="container py-4">
        <div class="jumbotron">
            <h1 class="display-4">Fast fertig!</h1>
            <p class="lead">Bitte wähle noch aus, für welche Gruppen man sich hier anmelden kann...</p>
            <hr class="my-4">

            <div class="form-check" v-for="group in groups">
                <input class="form-check-input" type="checkbox" :value="group.id" v-model="myGroups">
                <label class="form-check-label">
                    {{ group.description }}
                </label>
            </div>

            <p class="lead mt-4">
                <a class="btn btn-primary btn-lg" href="#" role="button" @click="submit">Auswählen</a>
            </p>
        </div>
    </div>

</template>

<script>

export default {
    name: "Groups",
    props: ['church', 'groups'],
    data() {
        return {
            myGroups: [],
        }
    },
    methods: {
        submit() {
            let record = { groups: [] };
            this.groups.forEach(group => {
                if (this.myGroups.includes(group.id)) record.groups.push({ name: group.description, group_id: group.id });
            });
            this.$inertia.post(route('setup.groups.store', this.church.name.toLowerCase()), record);
        },
    }
}
</script>

<style scoped>

</style>
