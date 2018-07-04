class NecotiendaModel {
    constructor() {
        if (!new.target) {
            throw 'NTModel must be called with new';
        }

        let className = this.constructor.name;

        if (className.substr(0,7) != "NTModel") {
            throw "Error: All Models class name children has to start with 'NTModel' word";
        }

        console.log(this.constructor.name);
    }
}

class NTModelProduct extends NecotiendaModel {
    constructor(){
        super();
    }
}
