<template>
  <br>
  <div :class="color" :title="title">{{ name }}</div>
  <button class="btn btn-dark" @click="decrement" :disabled="decDis">
    <strong>-</strong>
  </button>  
  <strong class="mx-2">{{ count }}</strong>
  <button class="btn btn-dark" @click="increment" :disabled="incDis">
    <strong>+</strong>
  </button>
  <br>
  <br>
  <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
            <tr>
                <td>
                  <input type="text" v-model="newItem.id[0]">
                </td>                
                <td>
                  <input type="text" v-model="newItem.name[0]">
                </td>                
                <td>
                  <input type="text" v-model="newItem.price[0]">
                </td>                
                <td>
                  <button class="btn btn-success btn-sm" @click="addMore">Add Item</button>
                </td>
            </tr>
            <tr v-for="(item,index) in items2" :key="index">
              <td>
                  <input type="text" v-model="newItem.id[index+1]">
                </td>                
                <td>
                  <input type="text" v-model="newItem.name[index+1]">
                </td>                
                <td>
                  <input type="text" v-model="newItem.price[index+1]">
                </td>
                <td>
                  <button 
                    class="btn btn-sm btn-danger" 
                    @click="removeRecord(index)">
                      Remove
                  </button>
                </td>
            </tr>
      </tbody>
      <tfoot>
        <td></td>
        <td></td>
        <td><button @click="handleFormSubmission">Submit</button></td>
        <td></td>
      </tfoot>
    </table>
</template>
<script>    
  export default{
    data(){
    return {
      name: 'Md Anwar Hossain',
      color: 'text-success',
      title: 'Your name',
      count: 0,
      incDis:false,
      decDis:true,
      items: [
        {id: 1, name: 'Apple', price: 180},
        {id: 2, name: 'Banana', price: 40},
        {id: 3, name: 'Mango', price: 100}
      ],
      items2: [
      ],
      newItem: {
        id: [],
        name: [],
        price: [],
      }

    }
  },
  methods: {
    increment(){
      if(this.count < 10)
      {
        this.decDis = false;
        this.count++;
        if(this.count >= 10)
        {
          this.incDis = true;
        }
      }
      else this.incDis = true;
      
    },    
    
    decrement(){
      if(this.count > 0)
      {
        this.incDis = false;
        this.count--;
        if(this.count <= 0)
        {
          this.decDis = true;
        }
      }
      else this.decDis = true;
    },
    
    addItem()
    {
        if(this.newItem.id != '' && this.newItem.name != '' && this.newItem.price != '')
        {
           let index = this.getIndex(this.newItem.id);
           if(index == -1)
           {
              this.items.push(this.newItem);
              this.newItem = {
                            id: '',
                            name: '',
                            price: '',
                          };
           }
           else alert('Item ID alread exists!');
        }
    },

    removeItem(id)
    {
      if(confirm('Do you want to remove this item?'))
      {
        let index = this.getIndex(id);
        if(index > -1)
        {
          this.items.splice(index,1);
        }
      }
    },

    getIndex(id)
    {
      return this.items.findIndex(item => item.id == id);
    },

    addMore()
    {
      this.items2.push({});
    },    
    
    removeRecord(index)
    {
        this.newItem.id.splice(index,1);
        this.newItem.name.splice(index,1);
        this.newItem.price.splice(index,1);

        this.items2.splice(index,1);
      
    },

    handleFormSubmission()
    {
      if(this.newItem.id.length != 0)
      {
        console.log(this.newItem);
      }
    }

  }
  }
</script>  
<style scoped>
button:disabled {
  cursor: not-allowed;
  pointer-events: all !important;
}
</style>