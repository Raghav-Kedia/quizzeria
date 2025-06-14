<script>
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    export let questionNumber;

    let question;
    let options = [];
    let correctOption = 1;

    $: dispatch("infoUpdate", {
        questionItem: [question, ...options, correctOption],
        questionNumber: questionNumber,
    });
</script>

<input type="text" placeholder={"Question " + questionNumber} bind:value={question} />
{#each [0, 1, 2, 3] as i}
    <div id="optionContainer">
        <input type="radio" id="option" value={i + 1} bind:group={correctOption} />&nbsp;&nbsp;
        <input type="text" placeholder={"Option" + (i + 1)} bind:value={options[i]} />
    </div>
{/each}
<br /><br />

<style>
    #optionContainer {
        display: flex;
    }

    input[type="text"] {
        width: 100%;
        padding-block: 20px;
        /* padding-inline: 20px; */
        margin-bottom: 10px;
        border-radius: 10px;
        text-align: center;
    }
</style>
