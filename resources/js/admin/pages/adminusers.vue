<template>
    <div>
        <template>
            <div>
                <div class="content">
                    <div class="container-fluid">
                        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                            <p class="_title0">Tags <Button @click="addModal=true"><Icon type="md-add"/>Add Admin</Button></p>

                            <div class="_overflow _table_div">
                                <table class="_table">
                                    <!-- TABLE TITLE -->
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                    <!-- TABLE TITLE -->

                                    <!-- ITEMS -->
                                    <tr v-for="(user, i) in users" :key="i" v-if="users.length">
                                        <td>{{user.id}}</td>
                                        <td class="_table_name">{{user.fullName}}</td>
                                        <td>{{user.email}}</td>
                                        <td>{{user.roleName}}</td>
                                        <td>{{user.created_at}}</td>
                                        <td>
                                            <Button type="info" size="small" @click="showEditModal(user, i)">Edit</Button>
                                            <Button type="error" size="small" @click="showDeleteModel(user, i)" :loading="user.isDeleting">Delete</Button>
                                        </td>
                                    </tr>
                                    <!-- ITEMS -->
                                </table>
                            </div>
                        </div>

                        <!-- tag modal -->
                        <Modal
                            v-model="addModal"
                            title="Add admin"
                            :mask-closable="false"
                        >
                            <div class="space">
                                <Input v-model="data.fullName" type="text" placeholder="Full Name" />
                            </div>
                            <div class="space">
                                <Input v-model="data.email" type="text" placeholder="Email" />
                            </div>
                            <div class="space">
                                <Input v-model="data.password" type="password" placeholder="Password" />
                            </div>
                            <div class="space">
                                <Select v-model="data.role_id" style="width:200px" placeholder="User Type">
                                    <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
                                </Select>
                            </div>
                            <div slot="footer">
                                <Button type="default" @click="addModal=false">Close</Button>
                                <Button type="primary" @click="addAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add admin'}}</Button>
                            </div>
                        </Modal>

                        <!-- edit tag modal -->
                        <Modal
                            v-model="editModal"
                            title="Edit Tag"
                            :mask-closable="false"
                        >
                            <div class="space">
                                <Input v-model="editData.fullName" type="text" placeholder="Full Name" />
                            </div>
                            <div class="space">
                                <Input v-model="editData.email" type="text" placeholder="Email" />
                            </div>
                            <div class="space">
                                <Input v-model="editData.password" type="password" placeholder="Password" />
                            </div>
                            <div class="space">
                                <Select v-model="editData.role_id" style="width:200px" placeholder="User Role">
                                    <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
                                </Select>
                            </div>

                            <div slot="footer">
                                <Button type="default" @click="editModal=false">Close</Button>
                                <Button type="primary" @click="editAdmin" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Editing...' : 'Edit admin'}}</Button>
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
                fullName: '',
                email: '',
                password: '',
                role_id: null,
                roleName: '',
                allUsers: [],
            },
            addModal: false,
            editModal: false,
            isAdding: false,
            users: [],
            editData: {
                fullName: '',
                email: '',
                password: '',
                role_id: null,
            },
            index: -1,
            showDeleteModal: false,
            deleteItem: {},
            isDeleting: false,
            deletingIndex: -1,
            roles: [],
        }
    },

    methods: {
        pushData() {
            // each roles
            this.roles.map((role, index) => {
                // each user
                this.users.map((obj, index) => {
                    if (role.id == obj.role_id) {
                        this.users[index].roleName = role.roleName
                    }
                })
            })
        },
        async getTags() {
            const res = await this.callApi('get', 'tag', )
            if (res.status == 200) {
                this.tags = res.data
            } else {
                this.swr()
            }
        },
        async addAdmin() {
            if(this.data.fullName.trim() == '') return this.e('Full name is required!')
            if(this.data.email.trim() == '') return this.e('Email is required!')
            if(this.data.password.trim() == '') return this.e('Password is required!')
            if(!this.data.role_id) return this.e('Role is required!')

            const res = await this.callApi('post', 'user', this.data)
            if(res.status === 201) {
                this.users.unshift(res.data)
                this.s('Admin user has been added successfully!')
                this.addModal = false
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i])
                    }
                } else {
                    this.swr()
                }
            }
        },
        async editAdmin() {
            if(this.editData.fullName.trim() == '') return this.e('Full name is required!')
            if(this.editData.email.trim() == '') return this.e('Email is required!')
            if(!this.data.role_id) return this.e('Role is required!')

            const res = await this.callApi('post', 'update_user', this.editData)
            if(res.status === 201) {
                // get all users
                this.users[this.index] = this.editData
                this.s('User has been edited successfully!')
                this.editModal = false
            } else {
                if (res.status == 422) {
                    for (let i in res.data.errors) {
                        this.e(res.data.errors[i])
                    }
                } else {
                    this.swr()
                }
            }
        },
        showEditModal(user, index) {
            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
                role_id: user.role_id,
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
        const [res, resRole] = await Promise.all([
            await this.callApi('get', 'user'),
            await this.callApi('get', 'role')
        ])

        if (res.status == 200) {
            this.users = res.data
        } else {
            this.swr()
        }

        if (resRole.status == 200) {
            this.roles = resRole.data
        } else {
            this.swr()
        }

        this.pushData()
    },

}
</script>
