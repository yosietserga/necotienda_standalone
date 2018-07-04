class NecotiendaController {
    constructor() {
        if (!new.target) {
            throw 'NTController must be called with new';
        }

        let className = this.constructor.name;

        if (className.substr(0,7) != "NTModel") {
            throw "Error: All Controllers class name children has to start with 'NTController' word";
        }

        console.log(this.constructor.name);
    }
}

class NTControllerProduct extends NecotiendaController {
    constructor(){
        super();
    }
}
