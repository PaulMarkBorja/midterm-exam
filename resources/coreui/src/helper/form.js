import errors from './error.js';
class Form {
    /**
     * Create a new Errors instance.
     */
     constructor(data){
       this.originalData = data;

       for (let field in data) {
         this[field] = data[field];
       }

       this.errors = new errors();
     }

     data(){
       let data = {};
       for(let property in this.originalData){
         data[property] = this[property];
       }

       return data;
     }

     sync(){
       for(let property in this.originalData){
         this[property] = this.originalData[property];
       }
     }

     /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }

     get(url){
      return this.submit('get',url);
     }

     post(url){
       return this.submit('post',url);
     }
     patch(url){
       return this.submit('patch',url);
     }

     delete(url){
       return this.submit('delete',url);
     }
     submit(method, url){
       return new Promise((resolve, reject) => {
            axios[method](url, this.data())
                .then(response => {
                    // this.reset();
                    resolve(response.data);
                })
                .catch(errors => {
                    this.errors.fetch(errors.response.data.errors);
                    reject(errors.response.data.errors);
                });
        });
     }
}
export { Form as default }

//
// class Form {
//   construct(data){
//     // console.log("New Form Intance Created");
//     this.originalData = data;
//
//     for (let field in data) {
//       this[field] = data[field];
//     }
//   }
//
//   data(){
//     let data = {};
//     console.log(this.originalData);
//     for(let property in this.originalData){
//       data[property] = this[property];
//     }
//
//     return data;
//   }
//
//   get(url){
//
//   }
//
//   submit(method, url){
//     Vue.$http[method](url, this.data()).then( response => {
//       return response.data;
//     });
//   }
// }
//
// export { Form as default }
