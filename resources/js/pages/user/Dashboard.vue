<template>
    <div class="user-poll-vote">
        <div class="alert alert-danger" v-if="has_error">
          <p>All Fields are required</p>
        </div>
        <div class="alert alert-success" v-if="has_success">
          <p>Polls updated successfully</p>
        </div>
          <form v-model="formData" autocomplete="off" @submit.prevent="savePolls" method="post">
            <div v-for="poll in polls" :key="poll.id">
                <strong> {{ poll.question }}</strong>
                
                <div class="ermsg"  v-for="list in poll.option" :key="list.id">                  
                    <label for="answer">                     
                    <input type="radio"  v-model="formData.answer[poll.id]" v-bind:id="list.id" class="form-check-input" :value="list.id" :name="'answer['+poll.id+']'"/>
                      &nbsp;  {{ list.name }}
                    </label>
                    <div class="clear-both"></div>
                </div>
            </div>
            <div class="pad0313">
              <button class="btn btn-primary btn-block width-auto">Update</button>
            </div>
        </form>
   </div>
</template>

<script>
  export default {
    data() {
      return {     
        has_error: false,
        has_success: false,
        polls: null,
        formData: {
           answer:[]
        },        
      }
    },
    mounted() {
      this.getPolls()
    },
    methods: {
      getPolls() {
        this.$http({
          url: `get-polls`,
          method: 'GET'
        })
          .then((res) => {
            this.polls = res.data.data
            this.formData.answer = res.data.data.selectedIds
          }, () => {
            this.has_error = true
          })
      },
      savePolls() {
         this.$http({
          url: `update-user-polls-vote`,
          method: 'POST',
          data: this.formData
        })
          .then((res) => {
           this.has_error = false
           this.has_success = true
           alert("Thanks for submitting your poll.")
          }, () => {
            this.has_error = true;
            alert("Please select an one option for atlease one question.")
          })        
      },
    }
  }
</script>
