var data = {
    name: 'Jack Slocum',
    title: 'Lead Developer',
    company: 'Ext JS, LLC',
    email: 'jack@extjs.com',
    address: '4 Red Bulls Drive',
    city: 'Cleveland',
    state: 'Ohio',
    zip: '44102',
    drinks: ['Red Bull', 'Coffee', 'Water'],
    kids: [{
        name: 'Sara Grace',
        age:3
    },{
        name: 'Zachary',
        age:2
    },{
        name: 'John James',
        age:0
    }]
};


var tpl = new Ext.XTemplate(
    '<p>Name: {name}</p>',
    '<p>Title: {title}</p>',
    '<p>Company: {company}</p>',
    '<p>Kids: ',
    '<tpl for="kids">',     // interrogate the kids property within the data
        '<p>{name}</p>',
    '</tpl></p>'
);

tpl.overwrite(panel.body, data);