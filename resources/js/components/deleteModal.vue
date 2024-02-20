<template>
    <div>
        <!-- Delete Alert Modal -->
        <Modal
            :value="getDeleteModel.showDeleteModal"
            :mask-closable="false"
            width="360">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p>Aer you sure want to delete category?</p>
                <p>Will you delete it?</p>
            </div>
            <template #footer>
                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteCategory">Delete</Button>
            </template>
        </Modal>
    </div>
</template>
<script>
    import store from "../store";
    export default {
        data() {
            return {
                isDeleting: false,
            }
        },
        methods: {
            async deleteCategory() {
                this.isDeleting = true
                const res = await this.callApi('post', store.state.deleteModalObj.deleteUrl, store.state.deleteModalObj.data)
                if (res.status === 201) {
                    // get all categories
                    this.s('Category has been deleted successfully!')
                    store.commit('setDeleteModal', true)
                } else {
                    this.swr()
                    store.commit('setDeleteModal', false)
                }
            },
        },
        computed: {
            getDeleteModel() {
                return store.getters.getDeleteModel
            }
        },
    }
</script>
