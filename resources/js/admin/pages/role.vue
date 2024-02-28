<template>
    <div>
        <template>
            <div>
                <div class="content">
                    <div class="container-fluid">
                        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                            <p class="_title0">Role Management <Button @click="addModal=true"><Icon type="md-add"/>New Role</Button></p>

                            <div class="_overflow _table_div">
                                <table class="_table">
                                    <!-- TABLE TITLE -->
                                    <tr>
                                        <th>ID</th>
                                        <th>Role Name</th>
                                        <th>Permission</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- TABLE TITLE -->

                                    <!-- ITEMS -->
                                    <tr v-for="(role, i) in roles" :key="i" v-if="roles.length">
                                        <td>{{role.id}}</td>
                                        <td class="_table_name">{{role.roleName}}</td>
                                        <td>{{role.created_at}}</td>
                                        <td>
                                            <Button type="info" size="small" @click="showEditModal(role, i)">Edit</Button>
                                            <Button type="error" size="small" @click="showDeleteModel(role, i)" :loading="role.isDeleting">Delete</Button>
                                        </td>
                                    </tr>
                                    <!-- ITEMS -->
                                </table>
                            </div>
                        </div>

                        <!-- role modal -->
                        <Modal
                            v-model="addModal"
                            title="Add Add Role"
                            :mask-closable="false"
                            :closable="false"
                        >
                            <Input v-model="data.roleName" type="text" placeholder="Role name..." clearable style="width: 200px" />
                            <div slot="footer">
                                <Button type="default" @click="addModal=false">Close</Button>
                                <Button type="primary" @click="addRole" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add role'}}</Button>
                            </div>
                        </Modal>

                        <!-- edit tag modal -->
                        <Modal
                            v-model="editModal"
                            title="Edit Role"
                            :mask-closable="false"
                        >
                            <Input v-model="editData.roleName" type="text" placeholder="Edit role..." clearable style="width: 200px" />
                            <div slot="footer">
                                <Button type="default" @click="editModal=false">Close</Button>
                                <Button type="primary" @click="editRole" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit role'}}</Button>
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
                roleName: '',
                permission: '',
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            roles: [],
            editData: {
                roleName: '',
            },
            index: -1,
            showDeleteModal: false,
            deleteItem: {},
            isDeleting: false,
            deletingIndex: -1,
        }
    },

    methods: {
        async addRole() {
            if(this.data.roleName.trim() == '') return this.e('Role Name is required!')
            const res = await this.callApi('post', 'role', this.data)
            if(res.status === 201) {
                // get all roles
                this.roles.unshift(res.data)
                this.s('Role has been added successfully!')
                this.addModal = false
                this.data.roleName = ''
            } else {
                if (res.status == 422) {
                    if (res.data.errors.roleName) {
                        this.e(res.data.errors.roleName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        async editRole() {
            if(this.editData.roleName.trim() == '') return this.e('Role Name is required!')
            const res = await this.callApi('post', 'update_role', this.editData)
            if(res.status === 201) {
                // get all roles
                this.roles[this.index].roleName = this.editData.roleName
                this.s('Role has been edited successfully!')
                this.editModal = false
            } else {
                if (res.status == 422) {
                    if (res.data.errors.roleName) {
                        this.e(res.data.errors.roleName[0])
                    }
                } else {
                    this.swr()
                }
            }
        },
        showEditModal(role, index) {
            let obj = {
                id: role.id,
                roleName: role.roleName,
            }
            this.editData = obj
            this.editModal = true
            this.index = index
        },
        async deleteTag() {
            this.isDeleting = true
            const res = await this.callApi('post', 'delete_tag', this.deleteItem)
        },
        showDeleteModel(tag, index) {
            this.deleteItem = tag
        }
    },

    async created() {
        const res = await this.callApi('get', 'role', )
        if (res.status == 200) {
            this.roles = res.data
        } else {
            this.swr()
        }
    }

}
</script>
