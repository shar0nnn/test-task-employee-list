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
    props: {
        position: Object,
    },

    data() {
        return {
            data: useForm({
                positionId: this.position.id,
                positionName: this.position.name,
            }),
        }
    },
}
</script>

<template>
    <ContentTitle title="Посади"/>

    <div class="card card-default col-6">
        <div class="card-header">
            <h3 class="card-title">Редагування посади</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form @submit.prevent="data.patch(`/positions/${data.positionId}`)">
            <div class="card-body">
                <div class="form-group">
                    <label for="position">Назва</label>
                    <input v-model="data.positionName" :class="{'is-invalid': data.errors.positionName}"
                           class="form-control" id="position" placeholder="Введіть назву посади" type="text">
                    <div v-if="data.errors.positionName" class="invalid-feedback">
                        {{ data.errors.positionName }}
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-3">
                    <div>
                        <div>
                            <span class="text-bold">Created at: </span>
                            {{ this.position.created_at }}
                        </div>
                        <div>
                            <span class="mt-3 text-bold">Updated at: </span>
                            {{ this.position.updated_at }}
                        </div>
                    </div>

                    <div>
                        <div>
                            <span class="text-bold">Admin created ID: </span>
                            {{ this.position.admin_created_id }}
                        </div>
                        <div>
                            <span class="mt-3 text-bold">Admin updated ID: </span>
                            {{ this.position.admin_updated_id }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mr-5">Зберегти</button>
                <Link href="/positions" class="btn btn-secondary">Назад</Link>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
