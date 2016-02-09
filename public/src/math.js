/*
 export function summ(x, ...y){
 var sum = parseFloat(x);

 y.map(el => {
 sum += el;
 console.log(sum);
 console.log(sum);

 });

 return sum;
 }*/
export class Mat{

  constructor(a,b){
    this.a = a;
    this.b = b;
  }

  summ(a,b){
    return a+b;
  }

  diff(a, b){
    return a - b ;
  }

  prod(){
    return this.a * this.b;
  }
}

