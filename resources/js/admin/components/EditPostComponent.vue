<template>
    <div class="container-fluid">
        <!-- Получаем в props id из контроллера и проверяем редактируем или создаем новый-->
        <h1 class="adminTitle" v-if="id == 0">Добавление поста.</h1>
        <h1 class="adminTitle" v-else>Редактирование поста.</h1>

        <hr>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="title">Title</span>
            </div>
            <input v-model="blogPost.blogPostTitle" type="text" class="form-control input-title" placeholder="Add title for preview" aria-label="Title"
                   aria-describedby="title">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="preview_text">Text preview</span>
            </div>
            <input v-model="blogPost.blogPostText" type="text" class="form-control input-text" placeholder="Add text for preview" aria-label="preview_text"
                   aria-describedby="preview_text">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="category_text">Text preview</span>
            </div>
            <input v-model="blogPost.blogPostCategory" type="text" class="form-control input-text" placeholder="Add category for preview" aria-label="category_text"
                   aria-describedby="category_text">
        </div>
        <div id="summernote">Hello Summernote</div>
        <button id="testSummerNote" type="button" class="btn btn-dark mt-1" @click="savePost" data-container="body" data-toggle="popover" data-placement="right" data-content="Не удалось сохранить, не все поля заполнены верно.">Save</button>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        props: ['id'],
        name: "py-4",
        data() {
            return {
                summernoteData: null,
                text: null,
                title: null,
                username: null,
                blogPost: {
                    blogPostTitle: null,
                    blogPostText: null,
                    blogPostCategory: null
                }
            }
        },
        methods: {
            savePost() {
                if (this.blogPost.blogPostText.length < 180) {
                    if (this.id != 0) {
                        let data = {
                            postData: $('#summernote').summernote('code'),
                            title: this.blogPost.blogPostTitle,//$('.input-title')[0].value,
                            text: this.blogPost.blogPostText,//$('.input-text')[0].value
                            category: this.blogPost.blogPostCategory,
                            id: this.id
                        };
                        axios.post('/admin/blog/editPost', data, {})
                        .then(response => {
                            console.log(response)
                        })
                        .catch(error => {
                            console.log(error.response)
                        });
                    }
                    else
                    {
                        this.summernoteData = {
                            postData: $('#summernote').summernote('code'),
                            title: this.blogPost.blogPostTitle,//$('.input-title')[0].value,
                            text: this.blogPost.blogPostText,//$('.input-text')[0].value
                            category: this.blogPost.blogPostCategory
                        };
                        axios.post('/admin/addNewPost', this.summernoteData, {})
                        .then(response => {
                            console.log(response)
                        })
                        .catch(error => {
                            console.log(error.response)
                        });
                    }
                    document.location.href = '/admin/blog/postList';
                } else {
                    $('.input-text').css("border-color", "red");
                    $('#testSummerNote').popover({
                        container: 'body',
                        trigger: 'focus'
                    })
                }
            }
        },
        created(){
            self = this;
            if (this.id != 0) {
                axios.get('/admin/blog/getpost/'+this.id).then(function (response) {
                    self.blogPost.blogPostText = response.data[0].text;
                    self.blogPost.blogPostTitle = response.data[0].title;
                    self.blogPost.blogPostCategory = response.data[0].category;
                    $('#summernote').summernote('code', response.data[0].blog_data);
                    console.log(response);
                })
                .catch(function (error) {
                    // handle error
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>

</style>