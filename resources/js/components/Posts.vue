<template>
    <div class="card-body">
        <div v-if="posts">
            <table class="table table-striped">

                <tbody>

                <tr v-for="(post,index ) in posts" :key="post.id">
                    <td>{{index+1}}</td>
                    <td>{{ post.title}} <span class="small-font"> &lbbrk;<a v-bind:href="post.url">{{ post.url}}</a>&rbbrk;</span><br/>
                        <span class="small-font">{{ post.score}} points by {{ post.created_by}}  <router-link :to="'/comment/' + post.id">{{ post.comment_count}} comment(s)</router-link></span>
                    </td>

                </tr>
                </tbody>

            </table>
            <pagination
                    v-bind:post="post"
                    v-on:page:update="updatePage"
                    v-bind:currentPage="currentPage"
                    v-bind:pageSize="pageSize">
            </pagination>


        </div>

        <div v-else class="mb-4">
            No posts yet<br/>
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

                currentPage: 0,
                pageSize: 0,
                visiblePosts: []

            };
        },
        beforeMount: function() {
            this.updatevisiblePosts();
        },
        created(){
            this.listPosts(1);
        },
        methods: {

            listPosts(page = 1) {
                axios.get('api/Posts?page=' + page).then((response) => {
                    this.posts = response.data.posts;
                })

            },
            // fetchPosts() {
            //     axios.get('api/FetchPosts').then((response) => {
            //         this.listPosts();
            //         this.getComments();
            //
            //     })
            //
            // },
            // getComments(){
            //     axios.get('api/Comments').then((response) => {
            //         this.listPosts();
            //         this.loadReplies();
            //     })
            // },
            // loadReplies(){
            //     axios.get('api/CommentsReplies').then((response) => {
            //         this.listPosts();
            //         this.listPosts();
            //     })
            // },

            updatePage(pageNumber) {
                this.currentPage = pageNumber;
                this.updatevisiblePosts();
            },
            updatevisiblePosts() {
                this.visiblePosts = this.posts.slice(this.currentPage * this.pageSize, (this.currentPage * this.pageSize) + this.pageSize);

                if (this.visiblePosts.length == 0 && this.currentPage > 0) {
                    this.updatePage(this.currentPage -1);
                }
            }

        },
        mounted(){
            this.listPosts();
            // this.fetchPosts();
            this.updatevisiblePosts();
        },
        updated() {
            this.listPosts();
        },
    }
</script>

