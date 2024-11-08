//HTTP REQUEST, RETURN ALL OF THE AVALIBLES LOTERRIES
const container = document.getElementById('container-active-loteries');

const getLoteries = async () => {
    try {
        const response = await fetch('https://api-resultadosloterias.com/api/results');
        if (!response.ok) {
            throw new Error('Error en la petición');
        }
        const { data } = await response.json();

        data.forEach(lotery => {
            console.log(lotery);

            container.innerHTML+=`
            <div class="card-lotery">
            <div class="color-card">
            </div>
            <div class="content-card">
                <img src="https://loteriademedellin.com.co/wp-content/uploads/2023/11/logo-loteria-de-medellin-1.png" alt="">
            <h4>${lotery.lottery}</h4>
            <p>Juegó: ${lotery.date}</p>
            <p>Resultado: ${lotery.result}</p>
            <button class="btn-card">Jugar!</button>
            </div>
        </div>
            `
            
        });
    } catch (error) {
        console.error('Error:', error);
    }
};

getLoteries();