
new Vue({
    el: '#app', // point th the hooker
    data: {
        tags: [
            { name: 'Tag1', type: 'success' },
            { name: 'Tag2222', type: 'the home' }

            // tag test, test for the components
        ],
        
    },

    methods: {
        open1() {
            const h = this.$createElement;
            this.$notify({
                title: '标题名称',
                message: h('i', { style: 'color: teal' }, '这是提示文案这是提示文案这是提示文案这是提示文案这是提示文案这是提示文案这是提示文案这是提示文案')
            });
        }
    }
});