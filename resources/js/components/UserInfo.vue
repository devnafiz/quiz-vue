<template>
	
	<span></span>
	     <p class="lead">
                                        asked by
                                        <a v-bind:href="user.url">{{user.name}}</a>


                                        <small class="text-muted">{{postDate}}</small>
                                        
                                    </p>
                                 
                                </div>
</template>

<script>
	
	export default{

		props:['model','label'],

		computed: {
             postDate(){
             	return this.label + " " + this.model.created_at;
             }
		},

		date(){

			return{

				user:this.model.user
			}
		}
	}
</script>