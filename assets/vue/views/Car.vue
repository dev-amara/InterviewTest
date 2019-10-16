<template>
    <div id="app" class="ui container">
        <h2>Gestion de la flotte de voitures</h2>
        <div>
            <div class="row">
                <div class="form-group col-sm-4" >
                    <label for="registration">Immatriculation</label>
                    <input min="1"
                           type="text"
                           id="registration"
                           class="form-control"
                           v-model.number="userData.registration">
                </div>
                <div class="form-group col-sm-4">
                    <label for="type">Type </label>
                    <input min="1"
                           type="text"
                           id="type"
                           class="form-control"
                           v-model.number="userData.car_type">
                </div>
                <div class="form-group col-sm-4">
                    <label for="parkingPlaceNb">Le numeros de la place du parking</label>
                    <input min="1"
                           max="10"
                           type="number"
                           id="parkingPlaceNb"
                           class="form-control"
                           v-model.number="userData.parking_place_nb">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="brand">Marque</label>
                    <input min="1"
                           max="10"
                           type="number"
                           id="brand"
                           class="form-control"
                           v-model.number="userData.brand">
                </div>
                <div class="form-group col-sm-4">
                    <label for="model">Model</label>
                    <input min="1"
                           max="10"
                           type="number"
                           id="model"
                           class="form-control"
                           v-model.number="userData.model">
                </div>
                <div class="form-group col-sm-4">
                    <label for="power">Puissance du moteur</label>
                    <input min="1"
                           max="10"
                           type="number"
                           id="power"
                           class="form-control"
                           v-model.number="userData.power">
                </div>
            </div>

            <button class="btn btn-primary"
                    @click.prevent="save(userData)"> Ajouter
            </button>
        </div>
        <div style="margin-top: 10px">
            <vuetable ref="vuetable"
                      :api-mode="false"
                      :fields="fields"
                      :per-page="perPage"
                      :data-manager="dataManager"
                      pagination-path="pagination"
                      @vuetable:pagination-data="onPaginationData"
            >
                <div slot="actions" slot-scope="props" style="margin: auto">
                    <button class="btn"
                            @click.prevent="onActionClicked('delete-item', props.rowData)">
                        <i class="material-icons">
                            delete
                        </i>
                    </button>
                </div>
            </vuetable>
            <div style="padding-top:10px">
                <vuetable-pagination ref="pagination"
                                     @vuetable-pagination:change-page="onChangePage"
                ></vuetable-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import Vuetable from "vuetable-2";
    import VuetablePagination from "vuetable-2/src/components/VuetablePagination";
    import FieldsDef from "./Fields.js";
    import axios from "axios";
    import _ from "lodash";

    export default {
        name: "app",

        components: {
            Vuetable,
            VuetablePagination
        },

        data() {
            return {
                userData: {
                    registration: '',
                    car_type: '',
                    parking_place_nb: '',
                    brand: '',
                    model: '',
                    power: ''
                },
                fields: FieldsDef,
                perPage: 3,
                data: []
            };
        },

        watch: {
            data(newVal, oldVal) {
                console.log(newVal, oldVal);
                this.$refs.vuetable.refresh();
            }
        },

        mounted() {
            axios.get("/api/v1/cars").then(response => {
                this.data = response.data.data;
            });
        },

        methods: {
            onPaginationData(paginationData) {
                this.$refs.pagination.setPaginationData(paginationData);
            },
            onChangePage(page) {
                this.$refs.vuetable.changePage(page);
            },
            dataManager(sortOrder, pagination) {
                if (this.data.length < 1) return;

                let local = this.data;

                // sortOrder can be empty, so we have to check for that as well
                if (sortOrder.length > 0) {
                    console.log("orderBy:", sortOrder[0].sortField, sortOrder[0].direction);
                    local = _.orderBy(
                        local,
                        sortOrder[0].sortField,
                        sortOrder[0].direction
                    );
                }

                pagination = this.$refs.vuetable.makePagination(
                    local.length,
                    this.perPage
                );
                console.log('pagination:', pagination)
                let from = pagination.from - 1;
                let to = from + this.perPage;

                return {
                    pagination: pagination,
                    data: _.slice(local, from, to)
                };
            },
            onActionClicked(action, data) {
                if('delete-item' === action) {
                    axios.delete("/api/v1/cars/"+ data.id)
                    axios.get("/api/v1/cars").then(response => {
                        this.data = response.data.data;
                    });
                    //this.data = this.dataManager().data.splice(index, 1)
                }
            },
            save(data) {
                axios.post("/api/v1/cars", data, {
                        headers: {
                            'Content-Type': 'application/json',
                        }
                    }
                );
                axios.get("/api/v1/cars").then(response => {
                    this.data = response.data.data;
                });
            }
        }
    };
</script>

<style>
    #app {
        font-family: "Avenir", Helvetica, Arial, sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        color: #2c3e50;
        margin-top: 20px;
    }
    button.ui.button {
        padding: 8px 3px 8px 10px;
        margin-top: 1px;
        margin-bottom: 1px;
    }
</style>
