<template>
    <div class="card-body">
        <div v-if="comments.length">
            <table class="table table-striped">

                <tbody>
                    <tr>
                         <td>
                             <table  v-for="(comment,index ) in comments" :key="comment.id">
                                 <tr><td><span class="small-font">{{ comment.created_by }}  <vue-moments-ago prefix="posted" suffix="ago" :date="comment.created_at"  lang="en"></vue-moments-ago></span></td></tr>
                                 <tr><td >
                                    {{ comment.comment | strippedContent}}

                                 </td></tr>
                             </table>
                         </td>
                    </tr>
                </tbody>

            </table>
        </div>
        <div v-else class="mb-4">
           No Comments<br/>
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
                comments: [],
                comment:{
                    id: '',
                    comment: '',
                    created_by:'',
                    created_at: ''

                },
            };
        },

        methods: {

            getComments() {
                var item = parseInt(this.$route.params.item);
                axios.get('api/Posts/comment/'+item).then((response) => {
                    this.comments = response.data.comments;
                })
            },

        },
        filters: {
            strippedContent: function(string) {
                return string.replace(/<\/?[^>]+>/ig, " ");
            }
        },
        mounted(){
            this.getComments();
        },
        updated() {
            this.getComments();
        },

    }
</script>


