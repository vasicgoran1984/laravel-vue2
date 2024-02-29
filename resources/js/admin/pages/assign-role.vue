<template>
    <div>
        <template>
            <div>
                <div class="content">
                    <div class="container-fluid">
                        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                            <p class="_title0">Role Management
                            <Select v-model="data.role_id" style="width:200px" placeholder="Select role type">
                                <Option :value="r.id" v-for="(r, i) in roles" :key="i" v-if="roles.length">{{r.roleName}}</Option>
                            </Select>

                            <div class="_overflow _table_div">
                                <table class="_table">
                                    <!-- TABLE TITLE -->
                                    <tr>
                                        <th>Resource Name</th>
                                        <th>Read</th>
                                        <th>Write</th>
                                        <th>Update</th>
                                        <th>Delete</th>
                                    </tr>
                                    <!-- TABLE TITLE -->

                                    <!-- ITEMS -->
                                    <tr v-for="(r, i) in resources" :key="i">
                                        <td>{{r.resourceName}}</td>
                                        <td><Checkbox v-model="r.read">Checkbox</Checkbox></td>
                                        <td><Checkbox v-model="r.write">Checkbox</Checkbox></td>
                                        <td><Checkbox v-model="r.update">Checkbox</Checkbox></td>
                                        <td><Checkbox v-model="r.delete">Checkbox</Checkbox></td>
                                    </tr>
                                    <!-- ITEMS -->
                                </table>
                            </div>
                        </div>
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
                role_id: null,
            },
            roles: [],
            resources: [
                {resourceName: 'Tags', read: true, write: false, update: false, delete: false, name: 'tags'},
                {resourceName: 'Category', read: false, write: false, update: false, delete: false, name: 'category'},
                {resourceName: 'Adminusers', read: false, write: false, update: false, delete: false, name: 'adminusers'},
                {resourceName: 'Role', read: false, write: false, update: false, delete: false, name: 'role'},
                {resourceName: 'Assign-role', read: false, write: false, update: false, delete: false, name: 'assign-role'},
                {resourceName: 'Home', read: false, write: false, update: false, delete: false, name: 'home'},
            ],
        }
    },

    methods: {

    },

    async created() {
        console.log(this.$route)
        const res = await this.callApi('get', 'role', )
        if (res.status == 200) {
            this.roles = res.data
        } else {
            this.swr()
        }
    }

}
</script>
