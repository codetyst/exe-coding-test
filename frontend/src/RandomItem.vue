<template>
    <div>
        <b>รายการไอเทมในคลัง: </b><br />
        <b-table :items="items" small />
        <hr />
        <b>ไอเทมที่ได้รับจากการสุ่ม: </b>
        <b-table id="my-table" :items="receiveItems" :per-page="perPage" :current-page="currentPage" small>
            <!-- A virtual column -->
            <template #cell(index)="data">
                {{ data.index + 1 + (currentPage - 1) * 10 }}
            </template>
        </b-table>
        <button @click="randomItems(100)">สุ่ม 100 ครั้ง</button><br />
    </div>
</template>

<script>
export default {
    data() {
        return {
            items: [],
            randomValue: null,
            receiveItems: [],
        }
    },
    created() {
        this.setDefaultItems();
    },
    methods: {
        randomItems(amount) {
            this.receiveItems = [];
            this.setDefaultItems();
            for (let i = 0; i < amount; i++) {
                this.randomValue = this.random(0.01, this.getTotalChance(), 2);
                this.randomItem(this.randomValue);
            }
        },
        setDefaultItems() {
            this.items = [
                { 'name': 'Small Potion Heal', 'game_item_id': 1050, 'chance': 0.12, 'stock': 1000 },
                { 'name': 'Medium Potion Heal', 'game_item_id': 3315, 'chance': 0.08, 'stock': 80 },
                { 'name': 'Big Potion Heal', 'game_item_id': 5830, 'chance': 0.06, 'stock': 15 },
                { 'name': 'Full Potion Heal', 'game_item_id': 1650, 'chance': 0.04, 'stock': 10 },
                { 'name': 'Small MP Potion', 'game_item_id': 10235, 'chance': 0.12, 'stock': 1000 },
                { 'name': 'Medium MP Potion', 'game_item_id': 892, 'chance': 0.08, 'stock': 80 },
                { 'name': 'Big MP Potion', 'game_item_id': 14736, 'chance': 0.06, 'stock': 15 },
                { 'name': 'Full MP Potion', 'game_item_id': 19001, 'chance': 0.04, 'stock': 8 },
                { 'name': 'Attack Ring', 'game_item_id': 135007, 'chance': 0.05, 'stock': 10 },
                { 'name': 'Defense Ring', 'game_item_id': 68411, 'chance': 0.05, 'stock': 10 },
                { 'name': 'Lucky Key', 'game_item_id': 118930, 'chance': 0.15, 'stock': 1000 },
                { 'name': 'Silver Key', 'game_item_id': 117462, 'chance': 0.15, 'stock': 1000 }
            ]

        },
        getTotalChance() {
            let totalChance = 0;
            this.items.forEach(item => {
                totalChance += item.chance;
            });
            return totalChance.toFixed(2);
        },
        random(min, max, decimals) {
            const str = (Math.random() * (max - min) + min).toFixed(decimals);
            return parseFloat(str);
        },
        randomItem(randomValue) {
            let totalChance = 0;
            for (let i = 0; i < this.items.length; i++) {
                if (randomValue <= (this.items[i].chance + totalChance)) {
                    this.updateReceiveItems(this.items[i].game_item_id, this.items[i].name);
                    this.removeStock(this.items[i].game_item_id);
                    break;
                }
                else {
                    totalChance += this.items[i].chance;
                }
            }
        },
        updateReceiveItems(gameItemId, name) {
            let oldReceivedItem = 0;
            for (let i = 0; i < this.receiveItems.length; i++) {
                if (this.receiveItems[i].game_item_id == gameItemId) {
                    oldReceivedItem = 1;
                    this.receiveItems[i].amount += 1;
                }
            }
            if (!oldReceivedItem) {
                this.receiveItems.push({
                    'name': name,
                    'game_item_id': gameItemId,
                    'amount': 1
                });
            }
        },
        removeStock(gameItemId) {
            for (let i = 0; i < this.items.length; i++) {
                if (gameItemId == this.items[i].game_item_id && this.items[i].stock > 0) {
                    this.items[i].stock -= 1;
                }
                if (this.items[i].stock == 0) {
                    this.items.splice(i, i + 1);
                }
            }
        }
    }
}
</script>