<script>
    import { createEventDispatcher } from "svelte";

    const dispatch = createEventDispatcher();

    export let question_text, option1, option2, option3, option4, correct_option;

    export let question_number;

    let selectedOption;

    $: dispatch("updateAnswer", {
        selectedOption: selectedOption == correct_option ? 1 : 0, //Send 1 if correct answer is selected, otherwise 0
        question_number: question_number,
    });
</script>

<input type="text" value={question_text} disabled />
<div class="optionContainer">
    <input type="radio" id="option" value="1" bind:group={selectedOption} />&nbsp;&nbsp;
    <input type="text" value={option1} disabled />
</div>
<div class="optionContainer">
    <input type="radio" id="option" value="2" bind:group={selectedOption} />&nbsp;&nbsp;
    <input type="text" value={option2} disabled />
</div>
<div class="optionContainer">
    <input type="radio" id="option" value="3" bind:group={selectedOption} />&nbsp;&nbsp;
    <input type="text" value={option3} disabled />
</div>
<div class="optionContainer">
    <input type="radio" id="option" value="4" bind:group={selectedOption} />&nbsp;&nbsp;
    <input type="text" value={option4} disabled />
</div>
<br />
<br />

<style>
    .optionContainer {
        display: flex;
    }

    input[type="text"] {
        width: 100%;
        padding-block: 20px;
        padding-inline: 20px;
        margin-bottom: 10px;
        border-radius: 10px;
        text-align: center;
    }
</style>
