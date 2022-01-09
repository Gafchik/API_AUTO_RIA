<template>
    <div class="d-flex justify-center mb-3">
        <v-card
            class="w-25"
            outlined
        >
            <v-form>
                <v-container>
                    <v-row align="center">
                        <v-col>
                            <v-select
                                v-model="selected_type"
                                @change="typeChange"
                                item-text="name"
                                item-value="value"
                                :items="types"
                                value="types.id"
                                label="Типы транспорта"
                            ></v-select>
                            <v-select
                                v-model="selected_mark"
                                @change="markChange"
                                item-text="name"
                                item-value="value"
                                :items="marks"
                                label="Марка"
                            ></v-select>
                            <v-select
                                v-model="selected_model"
                                item-text="name"
                                item-value="value"
                                :items="models"
                                label="Модель"
                            ></v-select>
                            <v-select
                                v-model="selected_region"
                                item-text="name"
                                item-value="value"
                                :items="regions"
                                label="Область"
                            ></v-select>
                            <v-select
                                @change="year_Change"
                                v-model="selected_year_B"
                                item-text="name"
                                item-value="value"
                                :items="years"
                                label="Год от"
                            ></v-select>
                            <v-select
                                @change="year_Change"
                                v-model="selected_year_E"
                                item-text="name"
                                item-value="value"
                                :items="years"
                                label="Год до"
                            ></v-select>
                            <v-btn
                                color="success"
                                dark
                                @click.prevent="serch"
                            >
                                Поиск
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>
        </v-card>
    </div>
</template>

<script>
import {mapActions, mapGetters} from "vuex";

export default {
    name: "Serch_form",
    data: () => ({
        selected_type: '',
        selected_mark: '',
        selected_model: '',
        selected_region: '',
        selected_year_B: '',
        selected_year_E: '',

    }),
    computed: {
        ...mapGetters('serch', ['types', 'marks', 'models', 'regions', 'years']),
    },
    methods: {
        ...mapActions('serch', [
            'select_types',
            'select_marks',
            'select_models',
            'select_regions',
            'select_result',
            'select_years']),
        typeChange() {
            this.select_marks(this.selected_type)
        },
        markChange() {
            this.select_models({type: this.selected_type, mark: this.selected_mark})
        },
        year_Change() {
            if (this.selected_year_B == '' || this.selected_year_E == '') {
                return;
            }
            if (this.selected_year_E < this.selected_year_B) {
                this.selected_year_E = this.selected_year_B;
                this.selected_year_B--;
            }
        },
        serch(){
           this.select_result({
               type: this.selected_type,
               mark: this.selected_mark,
               model: this.selected_model,
               region: this.selected_region,
               year_begin: this.selected_year_B,
               year_and: this.selected_year_E,
           });
        }
    },
    mounted: function () {
        this.select_types();
        this.select_regions();
        this.select_years();
    },
}
</script>

<style scoped>

</style>
