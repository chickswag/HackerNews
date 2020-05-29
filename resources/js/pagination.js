export default {
    name: 'pagination',
    props: ['posts', 'currentPage', 'pageSize'],
    methods: {
        updatePage(pageNumber) {
            this.$emit('page:update', pageNumber);
        },
        totalPages() {
            // return Math.ceil(this.posts.length / this.pageSize);
        },
        showPreviousLink() {
            return this.currentPage !== 0;
        },
        showNextLink() {
            return this.currentPage !== (this.totalPages() - 1);
        }
    }
}