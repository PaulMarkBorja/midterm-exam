class Errors {
    /**
     * Create a new Errors instance.
     */
    constructor() {
        this.errors = {};
    }

    all(){
      return Object.keys(this.errors).length > 0;
    }

    has(field){
      return this.errors.hasOwnProperty(field);
    }

    get(field){
      return this.errors[field][0];
    }

    fetch(errors){
      this.errors = errors;
    }

    clear(field){
      if (field) {
        delete this.errors[field];

        return;
      }

      this.errors = {};
    }
}
export { Errors as default }
