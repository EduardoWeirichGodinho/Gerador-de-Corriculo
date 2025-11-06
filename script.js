
function addExperiencia() {
    const containerExperiencia = document.createElement('div');
    containerExperiencia.classList.add('experiencia-item');
    
    containerExperiencia.innerHTML = `
        <div class="campos-experiencia">
            <input type="text" placeholder="Cargo" name="cargo[]" class="texto">
            <input type="text" placeholder="Empresa" name="empresa[]" class="texto">
            <input type="text" placeholder="Período" name="periodo[]" class="texto">
            <textarea placeholder="Descrição" name="descricao[]" class="texto"></textarea>
            <button type="button" class="btn btn-danger" onclick="excluirItem(this)">Excluir</button>
        </div>
    `;

    const btnExperiencia = document.getElementById('Experiencia');
    btnExperiencia.parentNode.insertBefore(containerExperiencia, btnExperiencia.nextSibling);
}

function adicionarFormacao() {
    const containerFormacao = document.createElement('div');
    containerFormacao.classList.add('formacao-item');
    
    containerFormacao.innerHTML = `
        <div class="campos-formacao">
            <input type="text" placeholder="Curso" name="curso[]" class="texto">
            <input type="text" placeholder="Instituição" name="instituicao[]" class="texto">
            <input type="text" placeholder="Ano de Conclusão" name="ano[]" class="texto">
            <button type="button" class="btn btn-danger" onclick="excluirItem(this)">Excluir</button>
        </div>
    `;

    const btnFormacao = document.getElementById('formacao');
    btnFormacao.parentNode.insertBefore(containerFormacao, btnFormacao.nextSibling);
}

function excluirItem(elemento) {
    elemento.closest('.experiencia-item, .formacao-item').remove();
}

document.addEventListener('DOMContentLoaded', function() {
    const dataNascimento = document.getElementById('data_de_nascimento');
    const idade = document.getElementById('Idade');

    if (dataNascimento && idade) {
        dataNascimento.addEventListener('change', function() {
            const dataAtual = new Date();
            const dataNasc = new Date(this.value);
            let idadeCalculada = dataAtual.getFullYear() - dataNasc.getFullYear();
            const mesAtual = dataAtual.getMonth();
            const mesNasc = dataNasc.getMonth();
            const diaAtual = dataAtual.getDate();
            const diaNasc = dataNasc.getDate();
            
            if (mesAtual < mesNasc || (mesAtual === mesNasc && diaAtual < diaNasc)) {
                idadeCalculada--;
            }
            
            idade.value = idadeCalculada;
        });
    }
});