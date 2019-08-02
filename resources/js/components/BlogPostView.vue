<template>
    <div class="ql-snow">
        <div style="width: 50vw" class="container ql-editor">
            <h1 class="display-4">{{blogPost.blogPostTitle}}</h1>
            <p>{{blogPost.blogPostCategory}}</p>
            <p class="blockquote-footer">{{blogPost.blogPostCreatedAt}}</p>
            <hr class="my-4">
            <div v-html="blogPost.blogPostData"></div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import hljs from 'highlight.js';

    export default {
        props: ['id'],
        name: "blog-post-view",
        data() {
            return {
                blogPost: {
                    blogPostTitle: null,
                    blogPostCategory: null,
                    blogPostCreatedAt: null,
                    blogPostData: null
                }
            }
        },
        created() {
            self = this;
            if (this.id != 0) {
                axios.get('/admin/blog/getpost/' + this.id).then(function (response) {

                    self.blogPost.blogPostData = response.data[0].blog_data;
                    self.blogPost.blogPostTitle = response.data[0].title;
                    self.blogPost.blogPostCategory = response.data[0].category;
                    self.blogPost.blogPostCreatedAt = response.data[0].created_at;
                    console.log(response);
                })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            }

        },
        updated() {
           document.querySelectorAll('pre').forEach((block) => {
                hljs.highlightBlock(block);
            });

        }
    }
</script>

<style scoped>

</style>
