<template>
    <div class="card-body">
        <div v-if="posts.length">
            <table class="table table-striped">

                <tbody>

                <tr v-for="(post,index ) in posts" :key="post.id">
                    <td>{{index+1}}</td>
                    <td>{{ post.title}} <span class="small-font"><a v-bind:href="post.url">{{ post.url}}</a></span><br/>
                        <span class="small-font">{{ post.score}} points by {{ post.created_by}}  <router-link :to="'/comment/' + post.id">{{ post.comment_count}} comment(s)</router-link></span>
                    </td>

                </tr>
                </tbody>

            </table>

        </div>
        <div v-else class="mb-4">
            No New Stories yet<br/>
        </div>
    </div>

</template>

<script>
    export default {
        data() {
            return {
                posts: [],
                post:{
                    id: '',
                    title: '',
                    comment_count: '',
                    score:'',
                    created_by:'',

                },
                title : "Hacker News",
                edit:false,
                pagination:{},

            };
        },

        methods: {

            listPosts() {
                axios.get('api/Posts/story/new').then((response) => {
                    this.posts = response.data.posts;
                })
            },

        },

        mounted(){
            this.listPosts();
        },
        updated() {
            this.listPosts();
        },
    }

</script>

