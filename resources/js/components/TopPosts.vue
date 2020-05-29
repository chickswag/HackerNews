<template>
    <div class="card-body">
        <div v-if="posts.length">
            <table class="table table-striped">

                <tbody>

                <tr v-for="(post,index ) in posts" :key="post.id">
                    <td>{{index+1}}</td>
                    <td>{{ post.title}} <span class="small-font"> <span v-if="post.url">&lbbrk;<a v-bind:href="post.url">{{ post.url}}</a>&rbbrk;</span></span><br/>
                        <span class="small-font">{{ post.score}} points by {{ post.created_by}}  <vue-moments-ago prefix="posted" suffix="ago" :date="post.created_at"  lang="en"></vue-moments-ago> <router-link :to="'/comment/' + post.id">{{ post.comment_count}} comment(s)</router-link></span>
                    </td>

                </tr>
                </tbody>

            </table>

        </div>
        <div v-else class="mb-4">
            No Top Stories yet<br/>
        </div>
    </div>

</template>

<script>

    import VueMomentsAgo from 'vue-moments-ago'
    export default {
        components: {
            VueMomentsAgo
        },
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
                axios.get('api/Posts/story/top').then((response) => {
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

