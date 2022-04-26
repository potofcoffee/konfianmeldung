<template>
    <div class="container py-4">
        <form ref="myForm" method="post" :action="route('register', church)">
            <div class="jumbotron">
                <h1 class="display-4">Herzlich willkommen!</h1>
                <p class="lead">Schön, dass du dieses Jahr bei Konfi in {{ church.name }} dabei sein willst! Wir freuen
                    uns
                    auf dich!</p>
                <div class="alert bg-info">Hier kannst du dich gleich anmelden. Dazu musst du uns nur ein paar Dinge
                    über dich und deine Eltern
                    verraten.
                </div>
                <hr class="my-4">

                <fieldset class="mb-5">
                    <legend>Ein paar Fragen zu dir selbst</legend>
                    <form-input name="konfi[vorname]" v-model="record.konfi.vorname" autofocus
                                label="Dein Vorname" required
                                help="Wenn du mehrere Vornamen hast, dann der, mit dem du normalerweise angeredet wirst"/>
                    <form-input name="konfi[details][personal.middlename]"
                                v-model="record.konfi.details.personal.middlename"
                                label="Weitere Vornamen"
                                help="Wenn du mehrere Vornamen hast, gib hier bitte alle weiteren an"/>
                    <form-input name="konfi[nachname]" v-model="record.konfi.nachname" required
                                label="Dein Nachname"/>
                    <form-input name="konfi[details][address.street]" v-model="record.konfi.details.address.street"
                                required
                                label="Straße und Hausnummer"/>
                    <form-input name="konfi[details][address.plz]" v-model="record.konfi.details.address.plz" required
                                label="Postleitzahl" type="number"/>
                    <form-input name="konfi[details][address.city]" v-model="record.konfi.details.address.city" required
                                label="Ort"/>
                    <form-input name="konfi[details][personal.tel]" v-model="record.konfi.details.personal.tel" required
                                label="Deine Handynummer"/>
                    <form-input name="konfi[email]" v-model="record.konfi.email"
                                label="Deine E-Mailadresse" help="Falls vorhanden" />
                    <form-group label="Dein Geburtsdatum" required>
                        <datepicker v-model="record.konfi.details.personal.birthdate" required typeable
                                    input-format="dd.MM.yyyy" :locale="locale" class="form-control" />
                    </form-group>
                    <form-input name="konfi[details][personal.birthplace]"
                                v-model="record.konfi.details.personal.birthplace" required
                                label="Wo bist du geboren?"/>
                </fieldset>
                <fieldset class="mb-5">
                    <legend>Deine Taufe</legend>
                    <div class="alert bg-info mb-3">
                        Für Konfi ist es nicht zwingend Voraussetzung, dass du schon getauft bist. Wenn nicht, wirst du
                        spätestens bei deiner
                        Konfirmation getauft. Wenn du schon getauft bist, dann verrate uns bitte ein paar Dinge zu
                        deiner Taufe (falls du
                        sie noch weißt). Wenn du nicht getauft bist, kannst du diesen Abschnitt einfach überspringen.
                    </div>
                    <form-group label="Wann wurdest du getauft?">
                        <datepicker v-model="record.konfi.details.taufe.date"  typeable
                                    input-format="dd.MM.yyyy" :locale="locale" class="form-control" />
                    </form-group>
                    <form-input name="konfi[details][taufe.paten]" v-model="record.konfi.details.taufe.paten"
                                label="Wer waren deine Taufpaten?"/>
                    <form-textarea name="konfi[details][taufe.spruch]" v-model="record.konfi.details.taufe.spruch"
                                   label="Wie lautet dein Taufspruch?"/>
                </fieldset>
                <fieldset class="mb-5">
                    <legend>Deine Schule</legend>
                    <p class="mb-3">Ab und zu gibt es für Konfi-Aktionen sogar schulfrei! Deshalb müssen wir wissen, wie
                        wir deine Schule erreichen können.</p>
                    <form-input name="konfi[details][personal.school]" v-model="record.konfi.details.personal.school"
                                required
                                label="Wie heißt die Schule, auf die du gehst?"/>
                    <form-input name="konfi[details][personal.school.class]"
                                v-model="record.konfi.details.personal.class" required
                                label="Wie heißt die Klasse, in die du gehst?"/>
                </fieldset>
                <fieldset v-for="(parent,parentIndex) in record.parents" class="mb-5">
                    <legend>Elternteil {{ parentIndex + 1 }}</legend>
                    <form-input :name="'parent['+parentIndex+'][vorname]'" v-model="parent.vorname"
                                :required="parentIndex == 0"
                                label="Vorname"/>
                    <form-input :name="'parent['+parentIndex+'][nachname]'" v-model="parent.nachname"
                                :required="parentIndex == 0"
                                label="Nachname"/>
                    <form-input :name="'parent['+parentIndex+'][phone]'" v-model="parent.phone"
                                :required="parentIndex == 0"
                                label="Telefonnummer"/>
                    <form-input :name="'parent['+parentIndex+'][mail]'" v-model="parent.mail" type="email"
                                :required="parentIndex == 0"
                                label="E-Mailadresse"/>
                </fieldset>
                <fieldset v-if="church.groups.length > 0">
                    <legend>Deine Konfigruppe</legend>
                    <div class="alert bg-info">Wir gehen davon aus, dass es dieses Jahr {{ church.groups.length }}
                        Gruppen geben wird. Hier kannst du wählen, in welche Gruppe du gerne gehen möchtest.
                        Wir versuchen unser Bestes, deinen Wunsch zu erfüllen (ohne Garantie!).
                    </div>
                    <div class="form-check" v-for="group in church.groups">
                        <input class="form-check-input" type="radio" v-model="record.group" :value="group.group_id">
                        <label class="form-check-label mb-2">
                            <div class="text-bold">{{ group.name }}</div>
                            <div v-if="group.description" class="text-sm">{{ group.description }}</div>
                            <div v-if="group.members.length > 0" class="text-sm">Bereits angemeldet: {{ group.members.join(', ') }}</div>
                            <div v-else class="text-sm">Bisher noch keine Anmeldungen</div>
                        </label>
                    </div>
                </fieldset>
            </div>
            <p class="lead mt-4">
                <a class="btn btn-primary btn-lg" href="#" role="button" @click="submit">Jetzt anmelden</a>
            </p>
        </form>
    </div>
</template>

<script>
import FormInput from "@/Components/Form/FormInput";
import FormTextarea from "@/Components/Form/FormTextarea";
import Datepicker from 'vue3-datepicker'
import FormGroup from "@/Components/Form/FormGroup";
import { de } from 'date-fns/locale';

export default {
    name: "Form",
    components: {FormGroup, FormTextarea, FormInput, Datepicker},
    props: ['church'],
    data() {
        return {
            locale: de,
            record: {
                group: this.church.groups.length > 0 ? this.church.groups[0].group_id : null,
                konfi: {
                    vorname: '',
                    nachname: '',
                    email: '',
                    details: {
                        personal: {
                            tel: '',
                            middlename: '',
                            birthplace: '',
                            birthdate: '',
                            school: '',
                            class: '',
                        },
                        taufe: {
                            date: '',
                            paten: '',
                            spruch: '',
                        },
                        address: {
                            street: '',
                            plz: this.church.zip,
                            city: this.church.city,
                        }
                    },
                },
                parents: [
                    {
                        vorname: '',
                        nachname: '',
                        mail: '',
                        phone: '',
                    },
                    {
                        vorname: '',
                        nachname: '',
                        mail: '',
                        phone: '',
                    },
                ]
            }
        }
    },
    methods: {
        submit() {
            if (this.$refs.myForm.checkValidity()) {
                axios.post(route('register', this.church.name), this.record).then(response => {
                    window.location.href = '/pdf/'+response.data;
                });
            }
        }
    }
}
</script>

<style scoped>
    .text-bold {
        font-weight: bold;
    }
</style>
