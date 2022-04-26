<template>
    <div class="container py-4">
        <div class="jumbotron">
            <h1 class="display-4">Willkommen, mutige:r Held:in!</h1>
            <p class="lead">Hier kannst du deine ganz eigene Konfi-Anmeldung einrichten.</p>
            <hr class="my-4">
            <div class="mb-4">Alles, was du dazu brauchst, ist ein "Token" <a
                href="https://verwaltung.konfiapp.de/administration/api-tokens/" target="_blank">aus der
                KonfiApp-Verwaltung</a>.
                Dieses sollte folgende "Scopes" haben:
                <div>
                    <span class="badge bg-light m-1">groups.create</span>
                    <span class="badge bg-light m-1">groups.members.create</span>
                    <span class="badge bg-light m-1">groups.members.read</span>
                    <span class="badge bg-light m-1">konfi-actions</span>
                    <span class="badge bg-light m-1">konfis.manage</span>
                    <span class="badge bg-light m-1">konfis.view</span>
                </div>
            </div>

            <div class="form-group mb-2">
                <label for="name">Gemeinde</label>
                <input name="name" class="form-control" autofocus  v-model="record.name"/>
            </div>
            <div class="form-group mb-2">
                <label for="token">Token</label>
                <input name="token" class="form-control" v-model="record.token"/>
            </div>
            <div class="form-group mb-2">
                <label for="token">Postleitzahl</label>
                <input name="token" class="form-control" v-model="record.zip"/>
            </div>
            <div class="form-group mb-2">
                <label for="token">Ort</label>
                <input name="token" class="form-control" v-model="record.city"/>
            </div>
            <form-input label="Benachrichtigung senden an" v-model="record.email"
                        help="Bei mehreren Adressen mit Kommas trennen" />

            <p class="lead mt-4">
                <a class="btn btn-primary btn-lg" href="#" role="button" @click="submit">Einrichten</a>
            </p>
        </div>
    </div>
</template>

<script>
import FormInput from "@/Components/Form/FormInput";
export default {
    name: "Index",
    components: {FormInput},
    data() {
        return {
            record: {
                name: '',
                token: '',
                zip: '',
                city: '',
                email: '',
            }
        }
    },
    methods: {
        submit() {
            this.$inertia.post(route('setup.church'), this.record);
        }
    }
}
</script>

<style scoped>

</style>
