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
            <input v-model="blogPost.blogPostTitle" type="text" class="form-control input-title"
                   placeholder="Add title for preview" aria-label="Title"
                   aria-describedby="title">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="preview_text">Text preview</span>
            </div>
            <input v-model="blogPost.blogPostText" type="text" class="form-control input-text"
                   placeholder="Add text for preview" aria-label="preview_text"
                   aria-describedby="preview_text">
        </div>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="category_text">Text preview</span>
            </div>
            <input v-model="blogPost.blogPostCategory" type="text" class="form-control input-category"
                   placeholder="Add category for preview" aria-label="category_text"
                   aria-describedby="category_text">
        </div>

        <!--Quill editor-->
        <div id="toolbar-container">
            <span class="ql-formats">
              <select class="ql-font">
                  <option value="AmaticSC">AmaticSC</option>
                  <option value="EBGaramond">EBGaramond</option>
                  <option value="Ubuntu">Ubuntu</option>
                  <option value="PTSans">PTSans</option>
                  <option value="OpenSansCondensed">OpenSansCondensed</option>
                  <option value="PlayfairDisplay">PlayfairDisplay</option>
                  <option value="Lacquer">Lacquer</option>
                  <option value="IndieFlower">IndieFlower</option>
                  <option value="Pacifico">Pacifico</option>
                  <option value="YanoneKaffeesatz">YanoneKaffeesatz</option>
                  <option value="Comfortaa">Comfortaa</option>
                  <option value="UbuntuCondensed">UbuntuCondensed</option>
                  <option value="Cuprum">Cuprum</option>
                  <option value="Caveat">Caveat</option>
                  <option value="Alegreya">Alegreya</option>
              </select>
              <select class="ql-size"></select>
            </span>
            <span class="ql-formats">
      <button class="ql-bold"></button>
      <button class="ql-italic"></button>
      <button class="ql-underline"></button>
      <button class="ql-strike"></button>
    </span>
            <span class="ql-formats">
      <select class="ql-color"></select>
      <select class="ql-background"></select>
    </span>
            <span class="ql-formats">
      <button class="ql-script" value="sub"></button>
      <button class="ql-script" value="super"></button>
    </span>
            <span class="ql-formats">
      <button class="ql-header" value="1"></button>
      <button class="ql-header" value="2"></button>
      <button class="ql-blockquote"></button>
      <button class="ql-code-block"></button>
    </span>
            <span class="ql-formats">
      <button class="ql-list" value="ordered"></button>
      <button class="ql-list" value="bullet"></button>
      <button class="ql-indent" value="-1"></button>
      <button class="ql-indent" value="+1"></button>
    </span>
            <span class="ql-formats">
      <button class="ql-direction" value="rtl"></button>
      <select class="ql-align"></select>
    </span>
            <span class="ql-formats">
      <button class="ql-link"></button>
      <button class="ql-image"></button>
      <button class="ql-video"></button>
      <button class="ql-formula"></button>
    </span>
            <span class="ql-formats">
      <button class="ql-clean"></button>
    </span>
        </div>
        <quill-editor v-model="content"
                      ref="myQuillEditor"
                      :options="editorOption"
                      @blur="onEditorBlur($event)"
                      @focus="onEditorFocus($event)"
                      @ready="onEditorReady($event)"></quill-editor>
<!-- end Quill -->
        <button id="testSummerNote" type="button" class="btn btn-dark mt-1" @click="savePost" data-container="body"
                data-toggle="popover" data-placement="right"
                data-content="Не удалось сохранить, не все поля заполнены верно.">Save
        </button>
        <button class="btn btn-danger mt-1" id="deletePost" v-on:click="deletePost">Удалить</button>
    </div>
</template>

<script>
    import 'quill/dist/quill.core.css'
    import 'quill/dist/quill.snow.css'
    import 'quill/dist/quill.bubble.css'

    import { quillEditor, Quill} from 'vue-quill-editor'
    import axios from 'axios';
    import hljs from 'highlight.js'
    import 'highlight.js/styles/monokai-sublime.css'

    var Font = Quill.import("formats/font");
    Font.whitelist = ["EBGaramond", "AmaticSC", "Ubuntu", "PTSans", "OpenSansCondensed", "PlayfairDisplay", "Lacquer", "IndieFlower", "Pacifico", "YanoneKaffeesatz", "Comfortaa", "UbuntuCondensed", "Cuprum", "Caveat", "Alegreya"];
    Quill.register(Font, true);
    export default {
        props: ['id'],
        components: {
            quillEditor
        },
        name: "py-4",
        data() {
            return {
                content: '<h2>Новая запись!</h2>',
                editorOption: {
                    // some quill options
                    modules: {
                        syntax: {
                            highlight: text => window.hljs.highlightAuto(text).value
                        },              // Include syntax module
                        toolbar: '#toolbar-container'  // Include button in toolbar
                    },
                    formats: {
                        Font: true
                    }
                },
                dClick: 0,
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
            deletePost() {
                if (this.dClick === 0) {
                    this.dClick++;
                    $("#deletePost").html('Повторно нажмите для подтверждения');
                } else {
                    let data = {
                        id: this.id
                    };
                    axios.post('/admin/blog/deletePost', data, {})
                        .then(response => {
                            console.log(response)
                        })
                        .catch(error => {
                            console.log(error.response)
                        });
                    document.location.href = '/admin/blog/postList';
                }
            },
            validate() {
                let result = true;
                if (this.blogPost.blogPostText.length === 0) {
                    $('.input-text').css("box-shadow", "0 0 0 0.2rem rgb(255, 0, 0, 0.25)");
                    result = false;
                } else {
                    $('.input-text').css("box-shadow", "none");
                }
                if (this.blogPost.blogPostTitle.length === 0) {
                    $('.input-title').css("box-shadow", "0 0 0 0.2rem rgb(255, 0, 0, 0.25)");
                    result = false;
                } else {
                    $('.input-title').css("box-shadow", "none");
                }
                if (this.blogPost.blogPostCategory.length === 0) {
                    $('.input-category').css("box-shadow", "0 0 0 0.2rem rgb(255, 0, 0, 0.25)");
                    result = false;
                } else {
                    $('.input-category').css("box-shadow", "none");
                }
                return result;
            },
            savePost() {
                if (this.blogPost.blogPostText.length < 180 && this.validate()) {
                    if (this.id != 0) {
                        let data = {
                            postData: this.content,
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
                    } else {
                        //TODO Переименовать в из summernote в quill
                        this.summernoteData = {
                            postData: this.content,
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
                    $('#testSummerNote').popover({
                        container: 'body',
                        trigger: 'focus'
                    })
                }
            },
            onEditorBlur(quill) {
                console.log('editor blur!', quill)
            },
            onEditorFocus(quill) {
                console.log('editor focus!', quill)
            },
            onEditorReady(quill) {
                console.log('editor ready!', quill)
            },
            onEditorChange({quill, html, text}) {
                console.log('editor change!', quill, html, text)
                this.content = html
            }
        },
        computed: {
            editor() {
                return this.$refs.myQuillEditor.quill
            }
        },
        created() {
            self = this;
            if (this.id != 0) {
                axios.get('/admin/blog/getpost/' + this.id).then(function (response) {
                    self.blogPost.blogPostText = response.data[0].text;
                    self.blogPost.blogPostTitle = response.data[0].title;
                    self.blogPost.blogPostCategory = response.data[0].category;
                    self.content = response.data[0].blog_data;
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
