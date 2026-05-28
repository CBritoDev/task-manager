export function debouce(fn: Function,delay:number =300){
    let timeoutId: ReturnType<typeof setTimeout> | null=null;

    return (...args:any[]) =>{
        if(timeoutId){
            clearTimeout(timeoutId);
        }
    }

    timeoutId = setTimeout(() =>{
        fn(...args);

    },delay);
}