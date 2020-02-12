class Validation{
	isAllLettersAndSpace(strInput){
        var lettersAndSpace = /^[a-zA-Z ]{1,191}$/;
        if(strInput.match(lettersAndSpace)) return true;
        else false;
    }

    isEmail(email) {
      var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(email);
    }

    isNumber(number){
		var num = /[0-9]+$/;
		return !num.test(number);
    }
}

export default Validation;