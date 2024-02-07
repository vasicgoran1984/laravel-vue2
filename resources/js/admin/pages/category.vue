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
                                        <th>Icon Image</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- TABLE TITLE -->

                                    <!-- ITEMS -->
                                    <tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
                                        <td>{{category.id}}</td>
                                        <td class="_table_name">{{category.categoryName}}</td>
                                        <td>{{category.iconImage}}</td>
                                        <td>{{category.created_at}}</td>
                                        <td>
                                            <Button type="info" size="small" @click="showEditModal(category)">Edit</Button>
                                            <Button type="error" size="small" @click="showDeleteModel(category)" :loading="category.isDeleting">Delete</Button>
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
                                <Upload
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
                            <div class="image_thumb">
                                <img :src="`/uploads/${data.iconImage}`" v-if="data.iconImage " />
                            </div>

<!--                            <Input v-model="data.iconImage" type="text" placeholder="Enter image..." clearable style="width: 200px" />-->
                            <div slot="footer">
                                <Button type="default" @click="addModal=false">Close</Button>
                                <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add tag'}}</Button>
                            </div>
                        </Modal>

                        <!-- edit tag modal -->
                        <Modal
                            v-model="editModal"
                            title="Edit Category"
                            :mask-closable="false"
                        >
                            <Input v-model="editData.categoryName" type="text" placeholder="Edit category..." clearable style="width: 200px" />
                            <Input v-model="editData.iconImage" type="text" placeholder="Edit icon..." clearable style="width: 200px" />
                            <div slot="footer">
                                <Button type="default" @click="editModal=false">Close</Button>
                                <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit category'}}</Button>
                            </div>
                        </Modal>

                        <!-- Delete Alert Modal -->
                        <Modal v-model="showDeleteModal" width="360">
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
                </div>
            </div>
        </template>


    </div>
</template>

<script>
import {del} from "vue";

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
                this.getCategories()
                this.s('Category has been added successfully!')
                this.addModal = false
                this.data.categoryName = ''
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

        },
        async deleteCategory() {
            this.isDeleting = true
            const res = await this.callApi('post', 'delete_category', this.deleteItem)
            if (res.status === 201) {
                // get all categories
                this.getCategories()
                this.s('Category has been deleted successfully!')
            } else {
                this.swr()
            }
            this.isDeleting = false
            this.showDeleteModal = false
        },
        showDeleteModel(category) {
            this.deleteItem = category
            this.showDeleteModal = true
        },
        handleSuccess (res, file) {
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
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },
    },

    async created() {
        this.token = window.Laravel.csrfToken
        this.getCategories()
    }

}
</script>
