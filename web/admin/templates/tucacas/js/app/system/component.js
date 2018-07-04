class NecotiendaComponent extends React.Component {
    constructor() {
        super();
    }

    _bind(...methods) {
        methods.forEach( (method) => this[method] = this[method].bind(this) );
    }

    /*
     componentDidMount() is invoked immediately after a
     component is mounted. Initialization that requires
     DOM nodes should go here. If you need to load data
     from a remote endpoint, this is a good place to
     instantiate the network request. Setting state in
     this method will trigger a re-rendering
     */
    componentDidMount() {

    }

}