class PMAForm{
    constructor(data){
        this.originalData = JSON.parse(JSON.stringify(data));

        Object.assign(this, data);

        this.errors = {};
    }

    data(){
        return Object.keys(this.originalData).reduce((data, attribute) => {
            data[attribute] = this[attribute];

            return data;
        }, {});
    }

    submit(endpoint){
        return axios.post(endpoint, this.data())
            .catch(this.onFail.bind(this));
    }

    onFail(error){
        this.errors = error.response.data.errors;

        throw error;
    }

    reset(){
        Object.assign(this, this.originalData);
    }
}

export default PMAForm;