
export default [
    {
        name: 'registration',
        title: '<span class="orange glyphicon glyphicon-user"></span> Immatriculation',
        sortField: 'registration'
    },
    {
        name: 'car_type',
        title: 'Type',
        sortField: 'car_type'
    },
    {
        name: 'brand',
        title: 'Marque',
        sortField: 'brand'
    },
    {
        name: 'model',
        title: 'Modele',
        sortField: 'model'
    },
    {
        name: 'parking_place_nb',
        title: 'Nombre de places',
        sortField: 'parking_place_nb'
    },
    {
        name: 'power',
        title: 'Puisssance du moteur',
        sortField: 'power'
    },
    {
        name: 'is_allocated',
        formatter: (value) => {
            return value === true ? 'OUI' : 'NON'
        },
        title: 'Alloué'
    },
    'actions'
]