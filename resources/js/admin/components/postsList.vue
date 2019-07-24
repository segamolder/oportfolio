<template>
    <ul class="list-group">
        <li class="list-group-item d-flex justify-content-between align-items-center" v-for="blogItem in blogPosts">
            {{blogItem.title}}
            <span>
                <bootstrap-toggle v-bind:onchange="setToggle(blogItem.isActive, blogItem.id)" v-model="blogItem.isActive" :options="{ on: 'Active', off: 'Disable', onstyle: 'success', size: 'small' }" :disabled="false" />
                <button type="button" class="btn btn-secondary btn-sm" @click="edit(blogItem.id)">Edit</button>
            </span>
        </li>
    </ul>
</template>

<script>
    import BootstrapToggle from 'vue-bootstrap-toggle'
    export default {
        props: ['id'],
        name: "posts-list",
        components: { BootstrapToggle },
        data() {
            return {
                blogPosts: null
            }
        },
        methods: {
            getAll() {
                self = this;
                axios.get('/blog/getAll').then(function (response) {
                    self.blogPosts = response.data;
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            },
            edit(id) {
                document.location.href = '/admin/blog/editPostView/'+id;
            },
            setToggle: function(isActive, id) {
                let data = {
                    isActive: isActive,
                    id: id
                };
                axios.post('/admin/blog/setActiveToggle', data, {})
                    .then(response => {
                        console.log(response)
                    })
                    .catch(error => {
                        console.log(error.response)
                    });
            }
        },
        created() {
            this.getAll();
        }
    }
</script>

<style scoped>

</style>