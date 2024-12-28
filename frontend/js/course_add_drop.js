let data = [
    ['魏瓔珞', 'JavaScript', 100],
    ['弘歷', 'JavaScript', 90],
    ['傅恆', 'JavaScript', 99],
    ['明玉', 'JavaScript', 89]
]


let tbody = document.querySelector('tbody')
for (let i = 0; i < data.length; i++) {
    let tr = document.createElement('tr')
    tbody.appendChild(tr)
    for (let j = 0; j < data[i].length; j++) {
        let td = document.createElement('td')
        td.innerHTML = data[i][j]
        tr.appendChild(td)
    }
    let td = document.createElement('td')
    td.innerHTML = `<a href='javascript:;'>刪除</a>`
    let a = td.children[0]
    a.addEventListener('click', () => {
        let parent = a.parentNode.parentNode
        console.log(parent);
        parent.remove()
    })
    // console.log(a);
    tr.appendChild(td)
}

let btn = document.querySelector('.btn')
btn.addEventListener('click', () => {
    let dataNew = []
    let name = prompt('請輸入姓名')
    let subject = prompt('請輸入科目')
    let score = Number(prompt('請輸入分數'))
    // console.log(name)
    // console.log(subject);
    // console.log(score);

    console.log(dataNew);
    if (name !== '' && subject !== '') {
        dataNew.push(name)
        dataNew.push(subject)
        dataNew.push(score)
        console.log(dataNew);
        let tr = document.createElement('tr')
        for (let i = 0; i < dataNew.length; i++) {
            let td = document.createElement('td')
            td.innerHTML = dataNew[i]
            tr.appendChild(td)
        }
        let td = document.createElement('td')
        td.innerHTML = `<a href='javascript:;'>刪除</a>`
        let a = td.children[0]
        a.addEventListener('click', () => {
            let parent = a.parentNode.parentNode
            console.log(parent);
            parent.remove()
        })
        tr.appendChild(td)
        console.log(tr);
        tbody.insertBefore(tr, tbody.children[0])
    }
    console.log(tbody.children[0]);
})