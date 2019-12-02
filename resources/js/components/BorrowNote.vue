<template>

 <form action="/admin/book" method="post" enctype="multipart/form-data">
            <div class="form-group">
               <br>
                <label>ID Reader</label>
                 <model-select :options="options2"
                                v-model="item2"
                                placeholder="select item">
                </model-select>
                <br>
                <label>Books</label>
    <multi-select :options="options"
                       :selected-options="items"
                       placeholder="select item"
                       @select="onSelect">
        </multi-select>
         <br>
        <input class="btn btn-primary" type="submit" value="Create">
            </div>
        </form>
      
</template>
 
<script>
  import _ from 'lodash'
  import { MultiSelect } from 'vue-search-select'
   import { ModelSelect } from 'vue-search-select'
  export default {
    data () {
      return {
        options: [],
        options2: [],
        searchText: '', // If value is falsy, reset searchText & searchItem
        items: [],
        item2: [],
        lastSelectItem: {},
      }
    },
   created() {
            axios.get('/admin/booklisting')
                .then(response =>{ 
                    this.options = response.data;
                    })
                  .catch(error =>{
                    this.errors.push(error);
                    console.log(error);
                })
            axios.get('/admin/librarycardlisting')
                .then(response =>{ 
                    this.options2 = response.data;
                    })
                  .catch(error =>{
                    this.errors.push(error);
                    console.log(error);
                })
        },
    methods: {
      onSelect (items, lastSelectItem) {
        this.items = items
        this.lastSelectItem = lastSelectItem
      },
      // deselect option
      reset () {
        this.items = [] // reset
      },
      // select option from parent component
      selectFromParentComponent () {
        this.items = _.unionWith(this.items, [this.options[0]], _.isEqual)
      },
      reset2 () {
        this.item2 = ''
      },
      selectFromParentComponent2 () {
        // select option from parent component
        this.item2 = this.options2[0].value
      }
    },
    components: {
      MultiSelect,ModelSelect
    }
  }
</script> 