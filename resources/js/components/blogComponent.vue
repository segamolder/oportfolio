<template>
    <div class="container px-0">
        <!--#region Верхние карточки блога-->
        <div class="row blogTopCards">
            <!--#region Главная карточка-->
            <!--TODO вынести в стили-->
            <div class="col-md-8 mainCard" style="cursor: pointer" @click="openPost(mainPosts.data[0].id)" v-bind:style="{ backgroundImage: 'url(' + mainPosts.data[0].img + ')' }">
                <div class="cardInfo">
                    <div class="cardCategory">{{mainPosts.data[0].category}}</div>
                    <div class="cardTitle">{{mainPosts.data[0].title}}</div>
                    <div class="cardDateTime">{{mainPosts.data[0].created_at}}</div>
                </div>
            </div>
            <!--#endregion-->
            <!--#region Второстепенные карточки-->
            <div class="col-md-4 secondaryCards">
                <div class="secondaryCard" @click="openPost(mainPosts.data[1].id)" v-bind:style="{ backgroundImage: 'url(' + mainPosts.data[1].img + ')' }">
                    <div class="cardInfo">
                        <div class="cardCategory">{{mainPosts.data[1].category}}</div>
                        <div class="cardTitle">{{mainPosts.data[1].title}}</div>
                        <div class="cardDateTime">{{mainPosts.data[1].created_at}}</div>
                    </div>
                </div>
                <div class="secondaryCard" @click="openPost(mainPosts.data[2].id)" v-bind:style="{ backgroundImage: 'url(' + mainPosts.data[2].img + ')' }">
                    <div class="cardInfo">
                        <div class="cardCategory">{{mainPosts.data[2].category}}</div>
                        <div class="cardTitle">{{mainPosts.data[2].title}}</div>
                        <div class="cardDateTime">{{mainPosts.data[2].created_at}}</div>
                    </div>
                </div>
            </div>
            <!--#endregion-->
        </div>
        <!--#endregion-->
        <!--#region Основные карточки-->
        <div class="row mr-0">
            <div class="cards col-md-8 px-0 mt-4">
                <div class="grid">
                    <div class="card">
                        <div class="cardImage" v-bind:style="{ backgroundImage: 'url(' + mainPosts.data[0].img + ')' }">
                            <div class="transformBlock"></div>
                        </div>
                        <div class="cardData">
                            <div class="cardTopInfo">
                                <div class="cardCategory mb-1">{{mainPosts.data[0].category}}</div>
                                <h1 class="cardTitle mb-1">{{mainPosts.data[0].title}}</h1>
                                <div class="cardDateTime">{{mainPosts.data[0].created_at}}</div>
                            </div>
                            <div class="cardText">{{mainPosts.data[0].text}}</div>
                            <button type="button" class="btn btn-outline-dark">Читать полностью</button>
                        </div>
                    </div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                    <div class="card"></div>
                </div>
            </div>
        </div>
        <!--#endregion-->
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "blog",
        data() {
            return {
                mainPosts: null
            }
        },
        methods: {
            getAll() {
                self = this;
                axios.get('/blog/posts?page=1').then(function (response) {
                    self.mainPosts = response.data;
                    console.log(response);
                })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
            },
            openPost(id) {
                document.location.href = "/blog/post/"+id;
            }
        },
        created() {
            this.getAll();
        }
    }
</script>

<style scoped>

</style>
