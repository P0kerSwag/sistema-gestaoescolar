const test = require('node:test');
const assert = require('node:assert/strict');
const fs = require('node:fs');

const source = fs.readFileSync(require('node:path').join(__dirname, '..', 'app.js'), 'utf8');
const start = source.indexOf('  function validate(form){');
const end = source.indexOf('\n  function formData(form)', start);
assert.ok(start >= 0 && end > start, 'A função de validação deve continuar disponível no app.js');

const validate = new Function('$', `${source.slice(start, end)}; return validate;`)(() => {});

function input({ name='field', value='', type='text', required=true, min, max } = {}) {
  return { name, value, type, required, min, max, focused:false, focus(){ this.focused=true; } };
}

function validateField(field) {
  const control=input(field), error={textContent:''}, classes=new Set();
  const label={
    querySelector(selector){ return selector==='input,select'?control:error; },
    classList:{ add(value){classes.add(value);}, remove(value){classes.delete(value);} }
  };
  const valid=validate({querySelectorAll(){return [label];}});
  return {valid, message:error.textContent, invalid:classes.has('invalid'), focused:control.focused};
}

test('bloqueia campo obrigatório vazio e destaca o campo',()=>{
  const result=validateField({name:'name',required:true,value:''});
  assert.equal(result.valid,false);
  assert.equal(result.message,'Campo obrigatório.');
  assert.equal(result.invalid,true);
  assert.equal(result.focused,true);
});

test('rejeita e-mail malformado',()=>{
  const result=validateField({name:'email',type:'email',value:'aluno-invalido'});
  assert.equal(result.valid,false);
  assert.equal(result.message,'Digite um e-mail válido.');
});

test('rejeita nota acima de 10',()=>{
  const result=validateField({name:'grade',type:'number',value:'11',min:'0',max:'10'});
  assert.equal(result.valid,false);
  assert.match(result.message,/entre 0 e 10/);
});

test('aceita frequência no limite de 100%',()=>{
  assert.equal(validateField({name:'attendance',type:'number',value:'100',min:'0',max:'100'}).valid,true);
});

test('rejeita telefone informado sem DDD suficiente',()=>{
  const result=validateField({name:'phone',type:'tel',required:false,value:'1234567'});
  assert.equal(result.valid,false);
  assert.equal(result.message,'Digite um telefone com DDD válido.');
});
