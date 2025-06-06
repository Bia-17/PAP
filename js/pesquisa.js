let availableKeywords=[
    'HTML',
    'CSS',
    'JavaScript'
];

const resultado=document.querySelector(".resultados");
const caixa=document.getElementById("form-pesquisa");

caixa.onkeyup=function(){
    let result = [];
    let input = caixa.value;
    if(input.lenght){
        result=availableKeywords.filter((keyword)=>{
            return keyword.toLowerCase().includes(input.toLowerCase());
        });
        console.log(result);
    }
    display(result);

    if(!result.lenght){
        resultadoscaixa.innerHTML='';
    }
}

function display(result){
    const conteudo=result.map((list)=>{
        return "<li oneclick=selectInput(this)>" + list + "</li>";
    });

    resultadoscaixa.innerHTML="<ul>" + conteudo.join('') + "</ul>";
}

function selectInput(list){
    caixa.value=list.innerHTML;
    resultadoscaixa.innerHTML='';
}