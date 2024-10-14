<script>

import {router} from "@inertiajs/vue3";

export default {
    name: "Login",
    props: {
        errors: Object,
    },

    data() {
        return {
            email: null,
            password: null,
        }
    },

    methods: {
        login() {
            router.post('/login', {
                email: this.email,
                password: this.password,
            }, {
                onError: errors => {
                    console.log(errors);
                },
            })
        }
    },
}
</script>

<template>
    <div class="login-page">
        <div class="login-box mb-5">
            <div class="login-logo">
                <span>Вхід у систему</span>
            </div>

            <div class="card">
                <div class="card-body login-card-body">
                    <form @submit.prevent="login">
                        <div class="input-group mb-3">
                            <input v-model="email" id="email" class="form-control" placeholder="Email">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input v-model="password" type="password" class="form-control" placeholder="Пароль">

                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Увійти</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
