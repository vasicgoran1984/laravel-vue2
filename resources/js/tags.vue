<template>
    <div>
        <template>
            <div>
                <div class="content">
                    <div class="container-fluid">
                        <!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
                        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
                            <p class="_title0">Tags <Button @click="addModal=true"><Icon type="md-add"/>New Tag</Button></p>

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
                                        <td>Economy</td>
                                        <td>
                                            <Button type="info" size="small">Info</Button>
                                            <Button type="error" size="small">Delete</Button>
                                        </td>
                                    </tr>
                                    <!-- ITEMS -->
                                </table>
                            </div>
                        </div>

                        <!-- tag modal -->
                        <Modal
                            v-model="addModal"
                            title="Common Modal dialog box title"
                            :mask-closable="false"
                            >
                            <Input v-model="data.tagName" type="text" placeholder="Enter tag..." clearable style="width: 200px" />
                            <div slot="footer">
                                <Button type="default" @click="addModal=false">Close</Button>
                                <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding">{{isAdding ? 'Adding...' : 'Add tag'}}</Button>
                            </div>
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
          isAdding: false,
          tags: [],
      }
    },

    methods: {
      async addTag() {
          if(this.data.tagName.trim() == '') return this.e('Tag name is required!')
          const res = await this.callApi('post', 'create_tag', this.data)
          if(res.status === 200) {
              const res = await this.callApi('get', 'get_tags', )
              if (res.status == 200) {
                  this.tags = res.data
              } else {
                  this.swr()
              }
              this.s('Tag has been added successfully!')
              this.addModal = false
              this.data.tagName = ''
          } else {
              this.swr()
          }
      },
    },

    async created() {
        const res = await this.callApi('get', 'get_tags', )
        if (res.status == 200) {
            this.tags = res.data
        } else {
            this.swr()
        }
    }

}
</script>
