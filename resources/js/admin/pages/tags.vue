<template>
    <div>
        <template>
            <div>
                <div class="content">
                    <div class="container-fluid">
                        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                            <p class="_title0">Tags <Button @click="addModal=true" v-if="isWritePermitted"><Icon type="md-add"/>New Tag</Button></p>

                            <div class="_overflow _table_div">
                                <table class="_table">
                                    <!-- TABLE TITLE -->
                                    <tr>
                                        <th>ID</th>
                                        <th>Tag Name</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- TABLE TITLE -->

                                    <!-- ITEMS -->
                                    <tr v-for="(tag, i) in tags" :key="i" v-if="tags.length">
                                        <td>{{tag.id}}</td>
                                        <td class="_table_name">{{tag.tagName}}</td>
                                        <td>{{tag.created_at}}</td>
                                        <td>
                                            <Button type="info" size="small" @click="showEditModal(tag, i)" v-if="isUpdatePermitted">Edit</Button>
                                            <Button type="error" size="small" @click="showDeleteModel(tag, i)" :loading="tag.isDeleting" v-if="isDeletedPermitted">Delete</Button>
                                        </td>
                                    </tr>
                                    <!-- ITEMS -->
                                </table>
                            </div>
                        </div>

                        <!-- tag modal -->
                        <Modal
                            v-model="addModal"
                            title="Add Tag"
                            :mask-closable="false"
                        >
                            <Input v-model="data.tagName" type="text" placeholder="Enter tag..." clearable style="width: 200px" />
                            <div slot="footer">
                                <Button type="default" @click="addModal=false">Close</Button>
                                <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add tag'}}</Button>
                            </div>
                        </Modal>

                        <!-- edit tag modal -->
                        <Modal
                            v-model="editModal"
                            title="Edit Tag"
                            :mask-closable="false"
                        >
                            <Input v-model="editData.tagName" type="text" placeholder="Edit tag..." clearable style="width: 200px" />
                            <div slot="footer">
                                <Button type="default" @click="editModal=false">Close</Button>
                                <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit tag'}}</Button>
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
                                <p>Aer you sure want to delete tag?</p>
                                <p>Will you delete it?</p>
                            </div>
                            <template #footer>
                                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting" @click="deleteTag">Delete</Button>
                            </template>
                        </Modal>

                    </div>
                </div>
            </div>
        </template>


    </div>
</template>

<script>
export default {

    data() {
        return {
            data: {
                tagName: '',
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            tags: [],
            editData: {
                tagName: '',
            },
            index: -1,
            showDeleteModal: false,
            deleteItem: {},
            isDeleting: false,
            deletingIndex: -1,
        }
    },

    methods: {
        async getTags() {
            const res = await this.callApi('get', 'tag', )
            if (res.status == 200) {
                this.tags = res.data
            } else {
                this.swr()
            }
        },
        async addTag() {
            if(this.data.tagName.trim() == '') return this.e('Tag name is required!')
            const res = await this.callApi('post', 'tag', this.data)
            if(res.status === 201) {
                // get all tags
                // this.getTags()
                this.tags.unshift(res.data)
                this.s('Tag has been added successfully!')
                this.addModal = false
                this.data.tagName = ''
            } else {
                if (res.status == 422) {
                    if (res.data.errors.tagName) {
                        this.e(res.data.errors.tagName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        async editTag() {
            if(this.editData.tagName.trim() == '') return this.e('Tag name is required!')
            const res = await this.callApi('post', 'update_tag', this.editData)
            if(res.status === 201) {
                // get all tags
                // this.getTags()
                this.tags[this.index].tagName = this.editData.tagName
                this.s('Tag has been edited successfully!')
                this.editModal = false
            } else {
                if (res.status == 422) {
                    if (res.data.errors.tagName) {
                        this.e(res.data.errors.tagName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        showEditModal(tag, index) {
            let obj = {
                id: tag.id,
                tagName: tag.tagName,
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },
        async deleteTag() {
            this.isDeleting = true
            const res = await this.callApi('post', 'delete_tag', this.deleteItem)
            if (res.status === 201) {
                // get all tags
                // this.getTags()
                this.tags.splice(this.deletingIndex, 1)
                this.s('Tag has been deleted successfully!')
            } else {
                this.swr()
            }
            this.isDeleting = false
            this.showDeleteModal = false
        },
        showDeleteModel(tag, index) {
            this.deleteItem = tag
            this.deletingIndex = index
            this.showDeleteModal = true
        }
    },

    async created() {
        const res = await this.callApi('get', 'tag', )
        if (res.status == 200) {
            this.tags = res.data
        } else {
            this.swr()
        }
    }

}
</script>
