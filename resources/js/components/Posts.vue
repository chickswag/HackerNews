<template>
    <div class="card-body">
        <div class="d-flex hacker-bg p-2">
            <span><b class="btn  flex-grow-1"  v-model="title"><img src="https://news.ycombinator.com/y18.gif" title="Hacker News"/> <i class="fa fa-list"></i> {{ title }}</b></span>
            <span class="btn  flex-grow-1" title="NEW STORIES" @click="filterByType('new')"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;New </span>
            <span class="btn  flex-grow-1" title="TOP STORIES" @click="filterByType('top')"><i class="fa fa-arrow-up"></i>&nbsp;&nbsp;&nbsp;Top</span>
            <span class="btn  flex-grow-1" title="BEST STORIES" @click="filterByType('best')"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;&nbsp;Best</span>
        </div>
        <div v-if="posts.length">
            <table class="table table-striped">
                <thead>
                <tr><td>#</td><td>Title</td></tr>
                </thead>
                <tbody>

                <tr v-for="(post,index ) in posts" :key="post.id">
                    <td>{{index+1}}</td>
                    <td>{{ post.title}}<br/>
                        <span class="small-font">{{ post.score}} points by {{ post.created_by}} | {{ post.comment_count}} comment(s)</span>
                    </td>

                </tr>
                </tbody>

            </table>
<!--            <pagination :data="tasks">-->
<!--                <span slot="prev-nav">&lt; Previous</span>-->
<!--                <span slot="next-nav">Next &gt;</span>-->
<!--            </pagination>-->
        </div>


        <div v-else class="mb-4">
            No posts yet<br/>
        </div>


    </div>

</template>
<style>
    .hacker-bg{
        background-color: #ff6600;
    }
    .small-font{
        font-size:8pt;
        color: #828282;
    }
</style>
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
            fetchPosts() {
                // axios.get('api/fetchPosts').then((response) => {
                //     this.listPosts();
                // })

            },
            listPosts() {
                axios.get('api/Posts').then((response) => {
                    this.posts = response.data.posts;
                })

            },
            filterByType(type){
                axios.post('api/StoryType/'+type).then((response) => {
                    this.posts = response.data.posts;
                })
            },
        },

        updated() {
            // this.fetchPosts();
            this.listPosts();
        },
        mounted(){
            this.fetchPosts();
            this.listPosts();
        },
    }
</script>

