new Vue({
  el: "#app", // point to the hooker
  data: {
   
  },

  methods: {
    //this is the message box method in element
    //references:https://element.eleme.io/#/en-US/component/notification
    introStatus() {
      const h = this.$createElement;
      this.$notify({
          title: 'What is Status?',
          message: h('i', { style: 'color: teal' }, 'If the status is "green", meaning the point is currently functional, otherwise it is not being maintianed')
      });
  }
  },
});
