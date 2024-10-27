<script>
import Layout from "../Layout/Layout.vue";
import ContentTitle from "../Layout/ContentTitle.vue";
import {Link, useForm} from "@inertiajs/vue3";

export default {
    name: "CreatePosition",
    layout: Layout,
    components: {
        ContentTitle, Link,
    },

    data() {
        return {
            data: useForm({
                positionName: null,
            }),
        }
    },
}
</script>

<template>
    <ContentTitle title="Посади"/>

    <div class="card card-default col-6">
        <div class="card-header">
            <h3 class="card-title">Додавання посади</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form @submit.prevent="data.post('/positions/store')">
            <div class="card-body">
                <div class="form-group">
                    <label for="position">Назва</label>
                    <input v-model="data.positionName" :class="{'is-invalid': data.errors.positionName}"
                           class="form-control" id="position" placeholder="Введіть назву посади" type="text">
                    <div v-if="data.errors.positionName" class="invalid-feedback">
                        {{ data.errors.positionName }}
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-5">Додати</button>
                <Link href="/positions" class="btn btn-secondary">Назад</Link>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
