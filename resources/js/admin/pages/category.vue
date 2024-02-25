<template>
    <div>
        <template>
            <div>
                <div class="content">
                    <div class="container-fluid">
                        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                            <p class="_title0">Categories <Button @click="addModal=true"><Icon type="md-add"/>New Category</Button></p>

                            <div class="_overflow _table_div">
                                <table class="_table">
                                    <!-- TABLE TITLE -->
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th>Image</th>
                                        <th>Icon Image</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- TABLE TITLE -->

                                    <!-- ITEMS -->
                                    <tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
                                        <td>{{category.id}}</td>
                                        <td>{{category.categoryName}}</td>
                                        <div class="img-category-list" v-if="category.iconImage">
                                            <td class="table_image">
                                                <img :src="`/uploads/${category.iconImage}`" />
                                            </td>
                                        </div>
                                        <td>{{category.iconImage}}</td>
                                        <td>{{category.created_at}}</td>
                                        <td>
                                            <Button type="info" size="small" @click="showEditModal(category)">Edit</Button>
                                            <Button type="error" size="small" @click="showDeleteModel(category, i)" :loading="category.isDeleting">Delete</Button>
                                        </td>
                                    </tr>
                                    <!-- ITEMS -->
                                </table>
                            </div>
                        </div>

                        <!-- tag modal -->
                        <Modal
                            v-model="addModal"
                            title="Add Category"
                            :mask-closable="false"
                        >
                            <Input v-model="data.categoryName" type="text" placeholder="Enter category..." clearable style="width: 200px" />

                            <div class="space">
                                <Upload v-show="!data.iconImage"
                                    ref="uploads"
                                    type="drag"
                                    :headers="{'x-csrf-token': token, 'X-Requested-With' : 'XMLHttpRequest'}"
                                    :on-success="handleSuccess"
                                    :on-error="handleError"
                                    :format="['jpg','jpeg','png']"
                                    :max-size="2048"
                                    :on-format-error="handleFormatError"
                                    :on-exceeded-size="handleMaxSize"
                                    action="/app/upload">
                                    <div style="padding: 20px 0">
                                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                        <p>Click or drag files here to upload</p>
                                    </div>
                                </Upload>
                            </div>
                            <div class="demo-upload-list" v-if="data.iconImage">
                                <img :src="`/uploads/${data.iconImage}`">
                                <div class="demo-upload-list-cover">
                                    <Icon type="ios-trash-outline" @click="deleteImage()"></Icon>
                                </div>
                            </div>

                            <div slot="footer">
                                <Button type="default" @click="addModal=false">Close</Button>
                                <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add category'}}</Button>
                            </div>
                        </Modal>

                        <!-- edit tag modal -->
                        <Modal
                            v-model="editModal"
                            title="Edit Category"
                            :mask-closable="false"
                            :closable="false"
                        >
                            <Input v-model="editData.categoryName" type="text" placeholder="Edit category..." clearable style="width: 200px" />

                            <div class="space">
                                <Upload v-show="isIconImageNew"
                                    ref="editDataUploads"
                                    type="drag"
                                    :headers="{'x-csrf-token': token, 'X-Requested-With' : 'XMLHttpRequest'}"
                                    :on-success="handleSuccess"
                                    :on-error="handleError"
                                    :format="['jpg','jpeg','png']"
                                    :max-size="2048"
                                    :on-format-error="handleFormatError"
                                    :on-exceeded-size="handleMaxSize"
                                    action="/app/upload">
                                    <div style="padding: 20px 0">
                                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                                        <p>Click or drag files here to upload</p>
                                    </div>
                                </Upload>
                            </div>
                            <div class="demo-upload-list" v-if="editData.iconImage">
                                <img :src="`uploads/${editData.iconImage}`">
                                <div class="demo-upload-list-cover">
                                    <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
                                </div>
                            </div>


                            <div slot="footer">
                                <Button type="default" @click="editModal=closeEditModal()">Close</Button>
                                <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit category'}}</Button>
                            </div>
                        </Modal>

                        <!-- Delete Alert Modal -->
                        <deleteModal></deleteModal>

                    </div>
                </div>
            </div>
        </template>


    </div>
</template>

<script>
import deleteModal from '../../components/deleteModal.vue'
import store from "../../store";
export default {

    data() {
        return {
            data: {
                categoryName: '',
                iconImage: '',
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            categories: [],
            editData: {
                categoryName: '',
                iconImage: '',
            },
            showDeleteModal: false,
            deleteItem: {},
            isDeleting: false,
            token: '',
            isIconImageNew: false,
            isEditingItem: false,
            deletingIndex: -1,
        }
    },

    methods: {
        async getCategories() {
            const res = await this.callApi('get', 'category', )
            if (res.status == 200) {
                this.categories = res.data
            } else {
                this.swr()
            }
        },
        async addCategory() {
            if(this.data.categoryName.trim() == '') {
                return this.e('Category name is required!')
            }

            const res = await this.callApi('post', 'category', this.data)
            if(res.status === 201) {
                // get all categories
                // this.getCategories()
                this.categories.unshift(res.data)
                this.s('Category has been added successfully!')
                this.addModal = false
                this.data.categoryName = ''
                this.data.iconImage = ''
                this.$refs.uploads.clearFiles()
            } else {
                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.e(res.data.errors.categoryName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        async editCategory() {
            if(this.editData.categoryName.trim() == '') return this.e('Category name is required!')
            const res = await this.callApi('post', 'update_category', this.editData)
            if(res.status === 201) {
                // get all categories
                this.getCategories()
                this.s('Category has been edited successfully!')
                this.editModal = false
                this.data.iconImage = ''
            } else {
                if (res.status == 422) {
                    if (res.data.errors.categoryName) {
                        this.e(res.data.errors.categoryName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        showEditModal(category) {
            let obj = {
                id: category.id,
                categoryName: category.categoryName,
                iconImage: category.iconImage,
            }
            this.editData = obj
            this.editModal = true
            this.isEditingItem = true
            this.isIconImageNew = false

        },
        showDeleteModel(category) {

            const delModalObj = {
                showDeleteModal: true,
                isDeleted: false,
                data: category,
                deleteUrl: 'delete_category',
            }
            store.commit('setDeletingModalObj', delModalObj)
        },
        handleSuccess (res, file) {
            if (this.isEditingItem) {
                this.editData.iconImage = res
                this.isIconImageNew = false
                return this.editData.iconImage = res
            }
            this.data.iconImage = res
        },
        handleError (res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File ' + file.name + ' is to large, no more than 2MB.'
            });
        },
        handleFormatError (file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize (file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File ' + file.name + ' is too large, no more than 2M.'
            });
        },
        async deleteImage(isAdd=true) {
            let image = this.editData.iconImage
            if (!isAdd) {
                this.isIconImageNew = true
                this.editData.iconImage = ''
                this.$refs.editDataUploads.clearFiles()
            } else {
                this.data.iconImage = ''
                this.$refs.uploads.clearFiles()
            }

            const res = await this.callApi('post', 'app/delete_image', {iconImage: image})
            if (res.status != 200) {
                this.data.iconImage = image
                this.swr()
            }
        },
        closeEditModal() {
            this.isEditingItem = false
            this.editModal = false
        }
    },
    async created() {
        this.token = window.Laravel.csrfToken
        this.getCategories()
    },
    components: {
        deleteModal,
    },
    computed: {
        getDeleteModel() {
            return store.getters.getDeleteModel
        }
    },
    watch: {
        getDeleteModel(obj) {
            if(obj.isDeleted) {
                this.categories.splice(this.deletingIndex, 1)
            }
        }
    }

}
</script>
