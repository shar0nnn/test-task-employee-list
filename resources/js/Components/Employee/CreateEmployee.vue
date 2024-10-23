<script>
import Layout from "../Layout/Layout.vue"
import ContentTitle from "../Layout/ContentTitle.vue"
import {Link, useForm} from "@inertiajs/vue3"
import Inputmask from 'inputmask'
import Datepicker from 'vue3-datepicker'

export default {
    name: "CreateEmployee",
    layout: Layout,
    components: {
        ContentTitle, Link, Datepicker,
    },
    props: {
        positions: Array,
    },

    data() {
        return {
            data: useForm({
                photo: null,
                fullName: null,
                phone: null,
                email: null,
                position: null,
                salary: null,
                manager: {
                    name: "",
                    id: null,
                },
                hiredAt: null,
            }),

            filteredManagers: [],
            debounceTimeout: null
        }
    },

    mounted() {
        Inputmask("+380 (99) 999-99-99").mask(this.$refs.phoneInput)
    },

    methods: {
        handleFileInput(event) {
            this.data.photo = event.target.files[0]
        },

        filterManagers() {
            clearTimeout(this.debounceTimeout)

            this.debounceTimeout = setTimeout(() => {
                if (this.data.manager.name !== "") {
                    axios.get(`/employees/get-names/${this.data.manager.name}`).then(result => {
                        this.filteredManagers = result.data.names
                    })
                } else {
                    this.selectManager("", null)
                }
            }, 500)
        },

        selectManager(name, id) {
            this.data.manager.name = name
            this.data.manager.id = id
            this.filteredManagers = []
        }
    },
}
</script>

<template>
    <ContentTitle title="Працівники"/>

    <div class="card card-default col-6">
        <div class="card-header">
            <h3 class="card-title">Додавання працівника</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form @submit.prevent="data.post('/employees/create')">
            <div class="card-body">

                <div class="form-group">
                    <label>Фото</label>
                    <div class="input-group">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input"
                                   :class="{'is-invalid': data.errors.photo}" @change="handleFileInput">
                            <label class="custom-file-label">Виберіть фото</label>
                        </div>
                    </div>
                    <div v-if="data.errors.photo" class="invalid-feedback">
                        {{ data.errors.photo }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Ім'я</label>
                    <input v-model="data.fullName" :class="{'is-invalid': data.errors.fullName}"
                           class="form-control" placeholder="Введіть ім'я" type="text">
                    <div v-if="data.errors.fullName" class="invalid-feedback">
                        {{ data.errors.fullName }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Телефон</label>
                    <input v-model="data.phone" ref="phoneInput" :class="{'is-invalid': data.errors.phone}"
                           class="form-control" placeholder="Введіть номер телефону" type="text">
                    <div v-if="data.errors.phone" class="invalid-feedback">
                        {{ data.errors.phone }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input v-model="data.email" :class="{'is-invalid': data.errors.email}"
                           class="form-control" placeholder="Введіть email" type="text">
                    <div v-if="data.errors.email" class="invalid-feedback">
                        {{ data.errors.email }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Посада</label>
                    <select v-model="data.position" class="form-control"
                            :class="{'is-invalid': data.errors.position}">
                        <option disabled :value=null>Виберіть посаду</option>
                        <option v-for="position in positions" :key="position.id" :value="position.id">
                            {{ position.name }}
                        </option>
                    </select>
                    <div v-if="data.errors.position" class="invalid-feedback">
                        {{ data.errors.position }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Зарплата</label>
                    <input v-model="data.salary" :class="{'is-invalid': data.errors.salary}"
                           class="form-control" placeholder="Визначіть зарплату" type="text">
                    <div v-if="data.errors.salary" class="invalid-feedback">
                        {{ data.errors.salary }}
                    </div>
                </div>

                <div class="form-group">
                    <label>Керівник</label>
                    <input v-model="data.manager.name" @input="filterManagers"
                           :class="{'is-invalid': data.errors['manager.name']}" type="text"
                           class="form-control" placeholder="Введіть ім'я керівника">
                    <div v-if="data.errors['manager.name']" class="invalid-feedback">
                        {{ data.errors['manager.name'] }}
                    </div>

                    <ul v-if="filteredManagers.length" class="list-group mt-1">
                        <li v-for="manager in filteredManagers" :key="manager.id"
                            @click="selectManager(manager.full_name, manager.id)"
                            class="list-group-item list-group-item-action">
                            {{ manager.full_name }}
                        </li>
                    </ul>
                </div>

                <div class="form-group">
                    <label>Дата працевлаштування</label>
                    <div class="input-group date">
                        <datepicker class="form-control" :class="{'is-invalid': data.errors.hiredAt}"
                                    placeholder="Виберіть дату працевлаштування" v-model="data.hiredAt"/>
                        <div class="input-group-append">
                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                        </div>
                    </div>
                    <div v-if="data.errors.hiredAt" class="invalid-feedback">
                        {{ data.errors.hiredAt }}
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-5">Додати</button>
                <Link href="/employees/list" class="btn btn-secondary">Назад</Link>
            </div>
        </form>
    </div>
</template>

<style scoped>
.invalid-feedback {
    display: block;
}
</style>
